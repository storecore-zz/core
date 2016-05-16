<?php
namespace StoreCore\Admin;

class RandomPassword
{
    /**
     * @var int $Length
     */
    private $Length = 7;

    /**
     * @var string $Password
     */
    private $Password;

    /**
     * @param int $length
     * @return void
     */
    public function __construct($length = 7)
    {
        $this->randomize($length);
    }

    /**
     * @param void
     * @return string
     * @uses \StoreCore\Admin\RandomPassword::get()
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Get the random password.
     *
     * @param void
     *
     * @return string
     *
     * @uses \StoreCore\Admin\RandomPassword::randomize()
     *     A password may be "published" only once.  Once the random password
     *     is used outside of the scope of this class, a new random password
     *     is generated.
     */
    public function get()
    {
        $return = $this->Password;
        $this->randomize($this->Length);
        return $return;
    }

    /**
     * @param int $length
     * @return void
     */
    private function randomize($length = 7)
    {
        // Password must be at least seven characters long.
        $this->Length = (int)$length;
        if ($length < 7) {
            $this->Length = 7;
        }

        // Password must contain at least one number.
        $password = mt_rand(0, 9);

        // Password must contain at least one uppercase letter.
        $password .= chr(mt_rand(65, 90));

        // Password must contain at least one lowercase letter.
        $password .= chr(mt_rand(97, 122));

        // Password must contain at least one special character.
        $password .= str_shuffle('!?@#$%*(){}[]')[0];

        do {
            switch (mt_rand(0, 3)) {
                case 0:
                    $password .= mt_rand(0, 9);
                    break;
                case 1:
                    $password .= chr(mt_rand(65, 90));
                    break;
                case 2:
                    $password .= chr(mt_rand(97, 122));
                    break;
                default:
                    $password .= str_shuffle('!?@#$%*(){}[]')[0];
            }
        } while (strlen($password) !== $this->Length);

        $cycles = mt_rand(3000, 5000);
        for ($i = 0; $i < $cycles ; $i++) {
            $password = str_shuffle($password);
        }

        $this->Password = $password;
    }
}
