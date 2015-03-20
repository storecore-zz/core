<?php
namespace StoreCore;

class User
{
    const VERSION = '0.0.1';

    private $UserID;
    private $Username;

    public function setUserID($user_id)
    {
        $this->UserID = (int)$user_id;
        return $this;
    }
    
    public function setUsername($username)
    {
        $this->Username = $username;
        return $this;
    }
}
