<?php
namespace StoreCore\Database;

/**
 * HTTP User-Agent Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class UserAgentMapper extends \StoreCore\Database\AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string $UserAgent
     * @var string $HashedPrimaryKey
     */
    private $UserAgent;
    private $HashedPrimaryKey;

    /**
     * Get the SHA-1 hash of the user agent string.
     *
     * @param void
     * @return string
     */
    public function getHash()
    {
        return $this->HashedPrimaryKey;
    }

    /**
     * Set the HTTP User-Agent string.
     *
     * @param string $user_agent
     * @return void
     */
    public function setUserAgent($user_agent)
    {
        $user_agent = trim($user_agent);

        // Limit TEXT string type storage to about 4096 bytes.
        mb_internal_encoding('UTF-8');
        if (mb_strlen($user_agent) > 4096) {
            $user_agent = mb_substr($user_agent, 0, 4093) . '…';
        }

        $this->UserAgent = $user_agent;
        $this->HashedPrimaryKey = sha1($user_agent);
    }

    /**
     * Create or update the user agent database record.
     *
     * @param void
     * @return void
     */
    public function update()
    {
        $stmt = $this->Connection->prepare('
            INSERT INTO sc_user_agents (user_agent_id, first_sighting, http_user_agent)
            VALUES (UNHEX(:user_agent_id), UTC_TIMESTAMP(), :http_user_agent)
            ON DUPLICATE KEY UPDATE last_sighting = UTC_TIMESTAMP()
        ');
        $stmt->bindParam(':user_agent_id', $this->HashedPrimaryKey, \PDO::PARAM_STR);
        $stmt->bindParam(':http_user_agent', $this->UserAgent, \PDO::PARAM_STR);
        $stmt->execute();
    }
}
