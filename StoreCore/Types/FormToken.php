<?php
namespace StoreCore\Types;

class FormToken
{
    /**
     * Get a random ASCII token.
     *
     * @param void
     * @return string
     */
    public static function getInstance()
    {
        $token = (string)null;
        for ($i = 1; $i <= 512; $i++) {
            switch (mt_rand(0, 2)) {
                case 0:
                    $ascii = mt_rand(48, 57);
                    break;
                case 1:
                    $ascii = mt_rand(65, 90);
                    break;
                default:
                    $ascii = mt_rand(97, 122);

            }
            $token .= chr($ascii);
        }
        return $token;
    }
}
