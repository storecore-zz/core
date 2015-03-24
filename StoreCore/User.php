<?php
namespace StoreCore;

class User
{
    /** @type string VERSION */
    const VERSION = '0.0.1';

    /**
     * @type int    $UserID
     * @type string $Username
     */
    private $UserID;
    private $Username;

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserID($user_id)
    {
        $this->UserID = (int)$user_id;
        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->Username = $username;
        return $this;
    }
}
