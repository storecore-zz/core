StoreCore Unit and Integration Testing
======================================

## Test for class versions

All StoreCore classes and abstract classes MUST contain a `VERSION` constant.
This constant MUST consist of a non-empty string that follows
[Semantic Versioning (SemVer)](https://semver.org/) for version numbers and
other version identifiers.

```php
/**
 * @group distro
 * @testdox VERSION constant is defined
 */
public function testVersionConstantIsDefined()
{
    $class = new \ReflectionClass('\StoreCore\FooBar');
    $this->assertTrue($class->hasConstant('VERSION'));
}

/**
 * @depends testVersionConstantIsDefined
 * @group distro
 * @testdox VERSION constant is not empty
 */
public function testVersionConstantIsNotEmpty()
{
    $this->assertNotEmpty(\StoreCore\FooBar::VERSION);
}

/**
 * @depends testVersionConstantIsDefined
 * @group distro
 * @testdox VERSION constant is string
 */
public function testVersionConstantIsString()
{
    $this->assertInternalType('string', \StoreCore\FooBar::VERSION);
}
```

The last two unit tests may be combined into a single unit test with two
assertions for a non-empty string:

```php
/**
 * @depends testVersionConstantIsDefined
 * @group distro
 * @testdox VERSION constant is non-empty string
 */
public function testVersionConstantIsNonEmptyString()
{
    $this->assertNotEmpty(\StoreCore\FooBar::VERSION);
    $this->assertInternalType('string', \StoreCore\FooBar::VERSION);
}
```


## Test if the class version matches the master branch

This unit test is included to assure that the current version of a class is at
least equal to the current production version of the class in the master
branch.

```php
/**
 * @depends testVersionConstantIsNonEmptyString
 * @group distro
 */
public function testVersionMatchesMasterBranch()
{
    $this->assertGreaterThanOrEqual('0.1.0', \StoreCore\FooBar::VERSION);
}
```


## Test for an extended class or an implemented interface

The PHPUnit assertion `assertInstanceOf()` can be used to test if a class
implements an interface by assessing if an object is an instance of the
interface.  The same type of unit test MAY be used to test for an extended
parent class or, more importantly, an extended abstract class:

```php
/**
 * @group hmvc
 * @testdox FooBar extends AbstractBaz
 */
public function testFooBarExtendsAbstractBaz()
{
    $object = new \StoreCore\FooBar();
    $this->assertInstanceOf(\StoreCore\AbstractBaz::class, $object);
}

/**
 * @group hmvc
 * @testdox FooBar implements QuxInterface
 */
public function testFooBarImplementsQuxInterface()
{
    $object = new \StoreCore\FooBar();
    $this->assertInstanceOf(\StoreCore\QuxInterface::class, $object);
}
```

The PHP operator `instanceof` MAY also be used for these assertions:

```php
/**
 * @group hmvc
 * @testdox FooBar extends AbstractBaz
 */
public function testFooBarExtendsAbstractBaz()
{
    $object = new \StoreCore\FooBar();
    $this->assertTrue($object instanceof \StoreCore\AbstractBaz);
}

/**
 * @group hmvc
 * @testdox FooBar implements QuxInterface
 */
public function testFooBarImplementsQuxInterface()
{
    $object = new \StoreCore\FooBar();
    $this->assertTrue($object instanceof \StoreCore\QuxInterface);
}
```

Unit tests for dependencies are grouped into the `@group hmvc` for
[Hierarchical Model-View-Controller (HMVC)](https://en.wikipedia.org/wiki/Hierarchical_model–view–controller).

Copyright © 2019 StoreCore™. All rights reserved.
