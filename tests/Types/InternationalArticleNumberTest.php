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
     * @testdox Public getNextNumber() method exists
     */
    public function testPublicGetNextNumberMethodExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getNextNumber'));
    }

    /**
     * @testdox Public getNextNumber() method is public
     */
    public function testPublicGetNextNumberMethodIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getNextNumber');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public getNextNumber() method returns object
     */
    public function testPublicGetNextNumberMethodReturnsObject()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('4006381333931');
        $this->assertTrue(is_object($ean->getNextNumber()));
    }

    /**
     * @testdox Public getNextNumber() method returns object
     */
    public function testPublicGetNextNumberMethodReturnsInternationalArticleNumber()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('4006381333931');
        $this->assertTrue(is_object($ean->getNextNumber()));
    }

    /**
     * @testdox Public getNextNumber() method returns InternationalArticleNumber object
     */
    public function testPublicGetNextNumberMethodReturnsInternationalArticleNumberObject()
    {
        $current_ean = new \StoreCore\Types\InternationalArticleNumber('4006381333931');
        $next_ean = $current_ean->getNextNumber();
        $this->assertTrue($next_ean instanceof \StoreCore\Types\InternationalArticleNumber);
    }

    /**
     * @testdox Public getNextNumber() method returns current number + 1
     */
    public function testPublicGetNextNumberMethodReturnsCurrentNumberPlusOne()
    {
        $current_number = '4006381333931';
        $current_ean = new \StoreCore\Types\InternationalArticleNumber($current_number);
        $next_ean = $current_ean->getNextNumber();
        $next_number = (string)$next_ean;
        $this->assertEquals($next_number, '4006381333948');
    }

    /**
     * @expectedException \RangeException
     * @testdox Public getNextNumber() method throws \RangeException on 99999
     */
    public function testPublicGetNextNumberMethodThrowsRangeExceptionOn99999()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('123400099999', false);
        $next_number = $ean->getNextNumber();
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

    /**
     * @testdox Public static validate() returns true on valid numbers
     */
    public function testPublicStaticValidateReturnsTrueOnValidNumbers()
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
