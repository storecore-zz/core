<?php
class InternationalArticleNumberTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group distro
     */
    public function testInternationalArticleNumberClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'InternationalArticleNumber.php');
    }

    /**
     * @group distro
     */
    public function testExtendedVarcharClassFileExists()
    {
        $this->assertFileExists(STORECORE_FILESYSTEM_LIBRARY_ROOT_DIR . 'Types' . DIRECTORY_SEPARATOR .  'Varchar.php');
    }

    /**
     * @group distro
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @group distro
     */
    public function testVersionMatchesDevelopmentBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\InternationalArticleNumber::VERSION);
    }

    public function testConstructorAddsValidCheckDigits()
    {
        // Article numbers and valid check digits
        $article_numbers = array(
            '019019806709' => 8,
            '072439315613' => 6,
            '275006487359' => 8,
            '871210051638' => 2,
            '871210057043' => 8,
            '871480000115' => 1,
            '880608827983' => 1,
        );
        foreach ($article_numbers as $article_number => $check_digit) {
            $ean = new \StoreCore\Types\InternationalArticleNumber($article_number);
            $this->assertTrue($article_number . $check_digit === (string)$ean);
        }
    }

    public function testConstructorGeneratesRandomInternalNumbersOnZero()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber(0, false);
        $ean = (string)$ean;
        $this->assertTrue(strlen($ean) === 13);
        $this->assertTrue(substr($ean, 0, 1) == '2');

        $ean = new \StoreCore\Types\InternationalArticleNumber('0', false);
        $ean = (string)$ean;
        $this->assertTrue(strlen($ean) === 13);
        $this->assertTrue(substr($ean, 0, 1) == '2');
    }

    /**
     * @testdox Public __toString() method exists
     */
    public function testPublicToStringMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox Public __toString() method returns string
     */
    public function testPublicToStringMethodReturnsString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string)$ean;
        $this->assertTrue(is_string($ean));
    }

    /**
     * @testdox Public __toString() method returns non-empty string
     */
    public function testPublicToStringMethodReturnsNonEmptyString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string)$ean;
        $this->assertFalse(empty($ean));
    }

    /**
     * @testdox Public __toString() method returns numeric string
     */
    public function testPublicToStringMethodReturnsNumericString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string)$ean;
        $this->assertTrue(is_numeric($ean));
        $this->assertTrue(ctype_digit($ean));
    }

    /**
     * @testdox Public __toString() method returns 13 characters
     */
    public function testPublicToStringMethodReturnsThirteenCharacters()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string)$ean;
        $this->assertTrue(strlen($ean) === 13);
    }

    /**
     * @testdox Public getCheckDigit() method exists
     */
    public function testPublicGetCheckDigitMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getCheckDigit'));
    }

    /**
     * @testdox Public getCheckDigit() method returns integer
     */
    public function testPublicGetCheckDigitMethodReturnsInteger()
    {
        $valid_ean_numbers = array(
            '0190198067098',
            '0724393156136',
            '2750064873598',
            '8712100516382',
            '8712100570438',
            '8714800001151',
            '8806088279831',
        );
        foreach ($valid_ean_numbers as $number) {
            $ean = new \StoreCore\Types\InternationalArticleNumber($number);
            $this->assertTrue(is_int($ean->getCheckDigit()));
        }
    }

    /**
     * @testdox Public getCheckDigit() method returns single digit
     */
    public function testPublicGetCheckDigitMethodReturnsSingleDigit()
    {
        $valid_ean_numbers = array(
            '0190198067098',
            '0724393156136',
            '2750064873598',
            '8712100516382',
            '8712100570438',
            '8714800001151',
            '8806088279831',
        );
        foreach ($valid_ean_numbers as $number) {
            $ean = new \StoreCore\Types\InternationalArticleNumber($number);
            $check_digit = $ean->getCheckDigit();
            $this->assertTrue($check_digit >= 1);
            $this->assertTrue($check_digit <= 9);
        }
    }

    /**
     * @testdox Public static getRandomNumber() method exists
     */
    public function testPublicStaticGetRandomNumberMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getRandomNumber'));
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getRandomNumber');
        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox Public static getRandomNumber() returns object
     */
    public function testPublicStaticGetRandomNumberReturnsObject()
    {
        $ean = \StoreCore\Types\InternationalArticleNumber::getRandomNumber();
        $this->assertTrue(is_object($ean));
    }

    /**
     * @testdox Public static getRandomNumber() returns InternationalArticleNumber object
     */
    public function testPublicStaticGetRandomNumberReturnsInternationalArticleNumberObject()
    {
        $ean = \StoreCore\Types\InternationalArticleNumber::getRandomNumber();
        $this->assertTrue($ean instanceof \StoreCore\Types\InternationalArticleNumber);
    }

    /**
     * @testdox Public static validate() method exists
     */
    public function testPublicStaticValidateMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('validate'));
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'validate');
        $this->assertTrue($method->isPublic());
        $this->assertTrue($method->isStatic());
    }

    public function testValidArticleNumbersAreValid()
    {
        $valid_ean_numbers = array(
            '0190198067098',
            '0724393156136',
            '2750064873598',
            '8712100516382',
            '8712100570438',
            '8714800001151',
            '8806088279831',
        );
        foreach ($valid_ean_numbers as $ean) {
            $this->assertTrue(\StoreCore\Types\InternationalArticleNumber::validate($ean));
        }
    }
}
