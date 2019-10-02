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
     * @group hmvc
     */
    public function testClassImplementsStringableInterface()
    {
        $object = new \StoreCore\Types\InternationalArticleNumber('9789043017121');
        $this->assertInstanceOf(\StoreCore\Types\StringableInterface::class, $object);
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsTypeInterface()
    {
        $object = new \StoreCore\Types\InternationalArticleNumber('9789043017121');
        $this->assertInstanceOf(\StoreCore\Types\TypeInterface::class, $object);
    }

    /**
     * @group hmvc
     */
    public function testClassImplementsValidateInterface()
    {
        $object = new \StoreCore\Types\InternationalArticleNumber('9789043017121');
        $this->assertInstanceOf(\StoreCore\Types\ValidateInterface::class, $object);
    }


    /**
     * @group distro
     * @testdox VERSION constant is defined
     */
    public function testVersionConstantIsDefined()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasConstant('VERSION'));
    }

    /**
     * @depends testVersionConstantIsDefined
     * @group distro
     * @testdox VERSION constant is non-empty string
     */
    public function testVersionConstantIsNonEmptyString()
    {
        $this->assertNotEmpty(\StoreCore\Types\InternationalArticleNumber::VERSION);
        $this->assertInternalType('string', \StoreCore\Types\InternationalArticleNumber::VERSION);
    }

    /**
     * @depends testVersionConstantIsNonEmptyString
     * @group distro
     * @testdox VERSION matches master branch
     */
    public function testVersionMatchesMasterBranch()
    {
        $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\Types\InternationalArticleNumber::VERSION);
    }


    /**
     * @testdox Constructor adds valid check digits
     */
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
            $this->assertSame($article_number . $check_digit, (string)$ean);
        }
    }

    /**
     * @testdox Constructor generates random internal numbers on zero
     */
    public function testConstructorGeneratesRandomInternalNumbersOnZero()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber(0, false);
        $ean = (string) $ean;
        $this->assertTrue(strlen($ean) === 13);
        $this->assertTrue(substr($ean, 0, 1) == '2');

        $ean = new \StoreCore\Types\InternationalArticleNumber('0', false);
        $ean = (string) $ean;
        $this->assertTrue(strlen($ean) === 13);
        $this->assertTrue(substr($ean, 0, 1) == '2');
    }


    /**
     * @testdox InternationalArticleNumber::__toString() exists
     */
    public function testInternationalArticleNumberToStringExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('__toString'));
    }

    /**
     * @testdox InternationalArticleNumber::__toString() is public
     */
    public function testInternationalArticleNumberToStringIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', '__toString');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox Public __toString() method returns string
     */
    public function testPublicToStringMethodReturnsString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string) $ean;
        $this->assertInternalType('string', $ean);
    }

    /**
     * @testdox InternationalArticleNumber::__toString() returns non-empty string
     */
    public function testInternationalArticleNumberToStringReturnsNonEmptyString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string) $ean;
        $this->assertNotEmpty($ean);
    }

    /**
     * @testdox InternationalArticleNumber::__toString() returns numeric string
     */
    public function testInternationalArticleNumberToStringReturnsNumericString()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string) $ean;
        $this->assertTrue(is_numeric($ean));
        $this->assertTrue(ctype_digit($ean));
    }

    /**
     * @testdox InternationalArticleNumber::__toString() returns 13 characters
     */
    public function testInternationalArticleNumberToStringReturnsThirteenCharacters()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('0190198067098');
        $ean = (string) $ean;
        $this->assertTrue(strlen($ean) === 13);
    }


    /**
     * @testdox InternationalArticleNumber::getCheckDigit() exists
     */
    public function testInternationalArticleNumberGetCheckDigitExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getCheckDigit'));
    }

    /**
     * @testdox InternationalArticleNumber::getCheckDigit() has one optional parameter
     */
    public function testInternationalArticleNumberGetCheckDigitHasOneOptionalParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getCheckDigit');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 0);
    }

    /**
     * @testdox InternationalArticleNumber::getCheckDigit() returns integer
     */
    public function testInternationalArticleNumberGetCheckDigitReturnsInteger()
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
            $this->assertInternalType('int', $ean->getCheckDigit());
        }
    }

    /**
     * @testdox InternationalArticleNumber::getCheckDigit() returns single digit
     */
    public function testInternationalArticleNumberGetCheckDigitReturnsSingleDigit()
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
     * @testdox InternationalArticleNumber::getNextNumber() exists
     */
    public function testInternationalArticleNumberGetNextNumberExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getNextNumber'));
    }

    /**
     * @testdox InternationalArticleNumber::getNextNumber() is public
     */
    public function testInternationalArticleNumberGetNextNumberIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getNextNumber');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox InternationalArticleNumber::getNextNumber() has no parameters
     */
    public function testInternationalArticleNumberGetNextNumberHasNoParameters()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getNextNumber');
        $this->assertTrue($method->getNumberOfParameters() === 0);
    }

    /**
     * @testdox InternationalArticleNumber::getNextNumber() returns object
     */
    public function testInternationalArticleNumberGetNextNumberReturnsObject()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('4006381333931');
        $this->assertInternalType('object', $ean->getNextNumber());
    }

    /**
     * @testdox InternationalArticleNumber::getNextNumber() returns new InternationalArticleNumber
     */
    public function testInternationalArticleNumberGetNextNumberReturnsNewInternationalArticleNumber()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('4006381333931');
        $this->assertInstanceOf(\StoreCore\Types\InternationalArticleNumber::class, $ean->getNextNumber());
        $this->assertNotSame($ean->getNextNumber(), $ean);
    }

    /**
     * @testdox InternationalArticleNumber::getNextNumber() returns current number + 1
     */
    public function testInternationalArticleNumberGetNextNumberReturnsCurrentNumberPlusOne()
    {
        $current_number = '4006381333931';
        $current_ean = new \StoreCore\Types\InternationalArticleNumber($current_number);
        $next_ean = $current_ean->getNextNumber();
        $next_number = (string)$next_ean;
        $this->assertEquals($next_number, '4006381333948');
    }

    /**
     * @expectedException \RangeException
     * @testdox InternationalArticleNumber::getNextNumber() throws \RangeException on 99999
     */
    public function testInternationalArticleNumberGetNextNumberThrowsRangeExceptionOn99999()
    {
        $ean = new \StoreCore\Types\InternationalArticleNumber('123400099999', false);
        $next_number = $ean->getNextNumber();
    }


    /**
     * @testdox InternationalArticleNumber::getRandomNumber() exists
     */
    public function testInternationalArticleNumberGetRandomNumberExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('getRandomNumber'));
    }

    /**
     * @testdox InternationalArticleNumber::getRandomNumber() is public
     */
    public function testInternationalArticleNumberGetRandomNumberIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getRandomNumber');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox InternationalArticleNumber::getRandomNumber() is static
     */
    public function testInternationalArticleNumberGetRandomNumberIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'getRandomNumber');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox InternationalArticleNumber::getRandomNumber() returns object
     */
    public function testInternationalArticleNumberGetRandomNumberReturnsObject()
    {
        $ean = \StoreCore\Types\InternationalArticleNumber::getRandomNumber();
        $this->assertInternalType('object', $ean);
    }

    /**
     * @testdox InternationalArticleNumber::getRandomNumber() returns InternationalArticleNumber object
     */
    public function testInternationalArticleNumberGetRandomNumberReturnsInternationalArticleNumberObject()
    {
        $ean = \StoreCore\Types\InternationalArticleNumber::getRandomNumber();
        $this->assertInstanceOf(\StoreCore\Types\InternationalArticleNumber::class, $ean);
    }


    /**
     * @testdox InternationalArticleNumber::validate() exists
     */
    public function testInternationalArticleNumberValidateExists()
    {
        $class = new \ReflectionClass('\StoreCore\Types\InternationalArticleNumber');
        $this->assertTrue($class->hasMethod('validate'));
    }

    /**
     * @testdox InternationalArticleNumber::validate() is public
     */
    public function testInternationalArticleNumberValidateIsPublic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'validate');
        $this->assertTrue($method->isPublic());
    }

    /**
     * @testdox InternationalArticleNumber::validate() is static
     */
    public function testInternationalArticleNumberValidateIsStatic()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'validate');
        $this->assertTrue($method->isStatic());
    }

    /**
     * @testdox InternationalArticleNumber::validate() has one required parameter
     */
    public function testInternationalArticleNumberValidateHasOneRequiredParameter()
    {
        $method = new \ReflectionMethod('\StoreCore\Types\InternationalArticleNumber', 'validate');
        $this->assertTrue($method->getNumberOfParameters() === 1);
        $this->assertTrue($method->getNumberOfRequiredParameters() === 1);
    }

    /**
     * @testdox InternationalArticleNumber::validate() returns true on valid numbers
     */
    public function testInternationalArticleNumberValidateReturnsTrueOnValidNumbers()
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
