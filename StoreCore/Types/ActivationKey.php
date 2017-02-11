<?php
namespace StoreCore\Types;

/**
 * Activation Key.
 *
 * This data object class provides the logic for something that needs some kind
 * of "activation" by a customer or prospect.  It can be used for random
 * strings like software product or license keys and coupon codes.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Security
 * @version   1.0.0
 */
class ActivationKey
{
    /**
     * @var string CHARACTER_SET
     *   String consisting of all ASCII characters used in a key.  To allow for
     *   case-insensitive user input, only uppercase letters are included.
     *   Not included are the numeric 0 (zero) and 1 (one), and the
     *   alphanumeric I, L, and O because these characters MAY be confusing
     *   to users.
     */
    const CHARACTER_SET = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /**
     * @var int $ChunkLength
     * @var int $Chunks
     * @var string|null $Key
     */
    private $ChunkLength = 4;
    private $Chunks = 3;
    private $Key;

    /**
     * @param int $chunck_length
     * @param int $chuncks
     * @return self
     */
    public function __construct($chunck_length = 4, $chuncks = 3)
    {
        $this->setChunkLength($chunck_length);
        $this->setChunks($chuncks);
    }

    /**
     * @param void
     * @return string
     * @uses get()
     */
    public function __toString()
    {
        return $this->get();
    }
    
    /**
     * Get the key string.
     *
     * @param string $delimiter
     * @return string
     */
    public function get($delimiter = '-')
    {
        if ($this->Key === null) {
            $this->randomize();
        }
        $return = chunk_split($this->Key, $this->ChunkLength, $delimiter);
        $return = rtrim($return, $delimiter);
        return $return;
    }

    /**
     * Generate or regenerate a random key.
     *
     * @param void
     * @return string
     */
    public function randomize()
    {
        $characters = str_shuffle(self::CHARACTER_SET);
        $mt_rand_max = strlen($characters) - 1;

        $number = (string)null;
        $length = $this->Chunks * $this->ChunkLength;
        for ($i = 1; $i <= $length; $i++) {
            $number .= substr($characters, mt_rand(0, $mt_rand_max), 1);
        }

        $this->Key = $number;
        return $number;
    }

    /**
     * Set the number of characters per group.
     *
     * @param int $number_of_characters
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setChunkLength($number_of_characters)
    {
        if (!is_int($number_of_characters)) {
            throw new \InvalidArgumentException();
        }
        $this->ChunkLength = $number_of_characters;
    }

    /**
     * Set the number of character groups.
     *
     * @param int $chuncks
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setChunks($chuncks)
    {
        if (!is_int($chuncks)) {
            throw new \InvalidArgumentException();
        }
        $this->Chunks = $chuncks;
    }
}
