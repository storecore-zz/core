<?php
namespace StoreCore\Database;

class Password
{
    private $Algorithm;
    private $Hash;
    private $Salt;

    /**
     * @param string|null $password
     * @return void
     */
    public function __construct($password = null)
    {
        if ($password !== null) {
            $this->setPassword($password);
        }
    }

    /**
     * @internal
     * @param string $password
     * @return void
     */
    private function encrypt($password)
    {
        $this->Salt = \StoreCore\Database\Salt::getInstance();
        $hash_algos = hash_algos();
        if (array_key_exists('sha512', $hash_algos)) {
            $this->Algorithm = 'sha512';
        } else {
            $this->Algorithm = 'sha1';
        }

        if ($this->Algorithm == 'sha1') {
            $this->Hash = sha1($this->Salt . $password);
        } else {
            $this->Hash = hash($this->Algorithm, $this->Salt . $password);
        }
    }

    /**
     * @param void
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->Algorithm;
    }

    /**
     * @param void
     * @return string
     */
    public function getHash()
    {
        return $this->Hash;
    }

    /**
     * @param void
     * @return string
     */
    public function getSalt()
    {
        return $this->Salt;
    }

    /**
     * @param void
     * @return void
     */
    public function setPassword($password)
    {
        $this->encrypt($password);
    }
}
