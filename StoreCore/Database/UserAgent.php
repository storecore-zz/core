<?php
namespace StoreCore\Database;

class UserAgent
{
    /**
     * @type string VERSION
     */
    const VERSION = '0.0.1';

    /**
     * @type string $UserAgent
     * @type string $HashedPrimaryKey
     */
    private $UserAgent;
    private $HashedPrimaryKey;

    /**
     * @param string $user_agent
     * @return void
     */
    public function __construct($user_agent = null)
    {
        if ($user_agent !== null) {
            $this->setUserAgent($user_agent);
        }
    }

    /**
     * @param string $user_agent
     * @return void
     */
    public function setUserAgent($user_agent)
    {
        $user_agent = trim($user_agent);
        mb_internal_encoding('UTF-8');
        if (mb_strlen($user_agent) > 255) {
            $user_agent = mb_substr($user_agent, 0, 254) . '…';
        }
        $this->UserAgent = $user_agent;
        $this->setPrimaryKey();
    }

    /**
     * Create a primary key.
     *
     * @param void
     * @return void
     */
    private function setPrimaryKey()
    {
        $hash = $this->UserAgent;
        $hash = mb_strtoupper($hash, 'UTF-8');
        $hash = sha1($hash);
        $this->HashedPrimaryKey = $hash;
    }

    /**
     * @param void
     * @return void
     */
    public function update()
    {
        $sql = 'INSERT INTO sc_user_agents (user_agent_id, first_sighting, http_user_agent) '
            . 'VALUES (?, UTC_TIMESTAMP(), ?) '
            . 'ON DUPLICATE KEY UPDATE last_sighting = UTC_TIMESTAMP()';

        $registry = \StoreCore\Registry::getInstance();
        if ($registry->has('Database')) {
            $dbh = $registry->get('Database');
        } else {
            $dbh = new \StoreCore\Database\Connection();
        }

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($this->HashedPrimaryKey, $this->UserAgent));
    }
}
