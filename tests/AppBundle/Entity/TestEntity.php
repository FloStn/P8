<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class TestEntity extends TestCase
{
    protected $object;

    abstract public function getObject();

    public function setUp()
    {
        $this->object = $this->getObject();
    }

    public function testId()
    {
        $this->assertNull($this->object->getId());
    }

    /**
     * @dataProvider provideScalarProperties
     * @param string $property
     * @param $value
     */
    public function testScalarProperties(string $property, $value)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $propertyAccessor->setValue($this->object, $property, $value);

        $this->assertEquals($value, $propertyAccessor->getValue($this->object, $property));
    }

    public function provideScalarProperties(): \Generator
    {
        
    }
}