<?php
namespace StoreCore\Database;

/**
 * Event Scheduler
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.0.1
 */
class EventScheduler extends AbstractModel
{
    /**
     * Execute scheduled events.
     *
     * @param void
     *
     * @return int
     *   Returns the number of executed events and 0 if no events were executed.
     */
    public function dispatch()
    {
        $events = $this->getCurrentEvents();
        if ($events === null) {
            return 0;
        }

        $count = 0;
        $sth = $this->Connection->prepare('
            UPDATE sc_cron_events
               SET executed = UTC_TIMESTAMP()
             WHERE route_id = :route_id
               AND scheduled = :scheduled
        ');
        foreach ($events as $event) {
            try {
                $event['route']->dispatch();
                $sth->bindParam(':route_id', $event['route_id'], \PDO::PARAM_INT);
                $sth->bindParam(':scheduled', $event['scheduled'], \PDO::PARAM_STR);
                $sth->execute();
                $count += 1;
            } catch (\Exception $e) {
                $this->Logger->error(
                    'Event scheduler failed to execute route #' . $event['route_id']
                    . ' scheduled at ' . $event['scheduled'] . ' UTC: '
                    . $e->getMessage()
                );
            }
        }

        $this->Logger->info('Event scheduler executed ' . $count . ' event(s).');
        return $count;
    }

    /**
     * Get current events to execute.
     *
     * @param void
     *
     * @return array|null
     *   Returns an array of routes or route collections for events due,
     *   or null if there currently is nothing to do.
     */
    public function getCurrentEvents()
    {
        $sth = $this->Connection->prepare('
              SELECT e.route_id, e.scheduled, r.route
                FROM sc_cron_events e
                JOIN sc_cron_routes r
                  ON e.route_id = r.route_id
               WHERE e.executed IS NULL
                 AND e.scheduled <= UTC_TIMESTAMP()
            ORDER BY e.scheduled ASC
        ');
        $sth->execute();
        $rows = $sth->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) {
            return null;
        }

        foreach ($rows as $key => $row) {
            $rows[$key]['route'] = unserialize($row['route']);
        }
        return $rows;
    }

    /**
     * Get a date and time interval.
     *
     * @param string $schedule
     *
     * @return \DateInterval
     */
    private function getDateInterval($schedule = '0 0 * * 0')
    {
        $schedule = explode(' ', $schedule);
        if (count($schedule == 5)) {
            if ($schedule[1] == '*' && $schedule[2] == '*' && $schedule[3] == '*' && $schedule[4] == '*') {
                // Hourly (# * * * *)
                return new \DateInterval('PT1H');
            } elseif ($schedule[2] == '*' && $schedule[3] == '*' && $schedule[4] == '*') {
                // Daily (# # * * *)
                return new \DateInterval('P1D');
            } elseif ($schedule[3] == '*' && $schedule[4] == '*') {
                // Monthly (# # # * *)
                return new \DateInterval('P1M');
            } elseif ($schedule[4] == '*') {
                // Yearly/annually (# # # # *)
                return new \DateInterval('P1Y');
            }
        }
        
        // Return 1 week (7 days) as default interval
        return new \DateInterval('P1W');
    }
    
    /**
     * Get the last scheduled date and time.
     *
     * @param void
     *
     * @return \DateTime
     *   Returns the last scheduled date and time as a DateTime object.
     *   If there currently are no scheduled events, the current date and time
     *   are used.
     */
    private function getLastDateTime()
    {
        $sth = $this->Connection->prepare('SELECT MAX(scheduled) FROM sc_cron_events');
        $sth->execute();
        $row = $sth->fetch(\PDO::FETCH_NUM);
        $sth = null;

        if ($row === null) {
            return new \DateTime();
        } else {
            return new \DateTime($row[0]);
        }
    }

    /**
     * Delete old schedules and events, and optimize the database table.
     *
     * @param void
     * @return void
     */
    public function optimize()
    {
        // Delete schedules and executed events after 1 month
        $this->Connection->exec('
            DELETE
               FROM sc_cron_routes 
              WHERE TIMESTAMPDIFF(MONTH, thru_date, UTC_TIMESTAMP()) >= 1
        ');
        $this->Connection->exec('
            DELETE
               FROM sc_cron_events
              WHERE executed IS NOT NULL
                AND TIMESTAMPDIFF(MONTH, executed, UTC_TIMESTAMP()) >= 1
        ');

        $this->Connection->exec('OPTIMIZE TABLE sc_cron_events');
        $this->Connection->exec('OPTIMIZE TABLE sc_cron_routes');
    }

    /**
     * Schedule events.
     *
     * @param object $route
     *
     * @param string $schedule
     *
     * @param \DateTime|string|null $end
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function schedule($route, $schedule, $description, $end = null)
    {
        // Start at midnight (00:00:00 UTC)
        $start = new \DateTime('tomorrow');
        
        if (!is_object($route) || !method_exists($route, 'dispatch')) {
            throw new \InvalidArgumentException(
                __METHOD__ . ' expects parameter 1 to be an object that supports a public dispatch() method.'
            );
        } else {
            $route = serialize($route);
        }

        $schedule = trim($schedule);
        $schedule = preg_replace('!\s+!', ' ', $schedule);
        $schedule = str_ireplace(array('; ', ' ;', ';', ', ', ' ,'), ',', $schedule);

        if ($schedule{0} == '@') {
            $mappings = array(
                '@yearly'   => '0 0 1 1 *',
                '@annually' => '0 0 1 1 *',
                '@monthly'  => '0 0 1 * *',
                '@weekly'   => '0 0 * * 0',
                '@daily'    => '0 0 * * *',
                '@hourly'   => '0 * * * *',
            );
            $schedule = strtolower($schedule);
            if (array_key_exists($schedule, $mappings)) {
                $schedule = $mappings[$schedule];
            }
        }

        $description = trim($description);
        
        if ($end !== null && is_string($end)) {
            $end = new \DateTime($end);
        }

        $sth = $this->Connection->prepare('
            INSERT
              INTO sc_cron_routes
                (from_date, thru_date, description, schedule, route)
              VALUES
                (:from_date, :thru_date, :description, :schedule, :route)
        ');
        $sth->bindValue(':from_date', $start->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        if ($end === null) {
            $sth->bindValue(':from_date', $end, \PDO::PARAM_NULL);
        } else {
            $sth->bindValue(':from_date', $end->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        }
        $sth->bindValue(':description', $description, \PDO::PARAM_STR);
        $sth->bindValue(':schedule', $schedule, \PDO::PARAM_STR);
        $sth->bindValue(':route', $route, \PDO::PARAM_STR);
        $sth->execute();

        $last_insert_id = $this->Connection->lastInsertId();
        
        // Schedule tasks without end date for 1 year
        if ($end === null) {
            $end = new \DateTime('+1 year');
        }
        
        $interval = $this->getDateInterval($schedule);

        // Schedule start date and start time
        $schedule = explode($schedule);
        if (count($schedule) == 5) {
            if (is_numeric($schedule[0])) {
                if (is_numeric($schedule[1])) {
                    $start->setTime($schedule[0], $schedule[1]);
                } else {
                    $start->setTime($schedule[0], 0);
                }
            }
        }

        // Create a period
        $period = new \DatePeriod($start, $interval, $end);
        // Get date and time values for upcoming events
        $values = array();
        foreach ($period as $datetime) {
            $values[] = "(" . $last_insert_id . ", '" . $datetime->format('Y-m-d H:i:s') . "')";
        }
        unset($datetime, $last_insert_id, $period);
        
        $sql = 'INSERT INTO sc_cron_events (route_id, scheduled) VALUES ' . implode(', ', $values);
        $this->Connection->exec($sql);
    }

    /**
     * Unschedule an event.
     *
     * @param int $route_id
     *   Unique identifier (primary key) of a previously scheduled event route.
     *
     * @return bool
     *   Returns true on success or false on failure.
     */
    public function unschedule($route_id)
    {
        if ($this->Connection->beginTransaction()) {
            $sth = $this->Connection->prepare('UPDATE sc_cron_routes SET thru_date = UTC_TIMESTAMP() WHERE route_id = :route_id');
            $sth->bindParam(':route_id', $route_id, \PDO::PARAM_INT);
            $sth->execute();
            $sth = $this->Connection->prepare('DELETE FROM sc_cron_events WHERE route_id = :route_id');
            $sth->bindParam(':route_id', $route_id, \PDO::PARAM_INT);
            $sth->execute();
            return $this->Connection->commit();
        } else {
            return false;
        }
    }
}
