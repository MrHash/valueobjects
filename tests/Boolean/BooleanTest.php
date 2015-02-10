<?php

namespace ValueObjects\Tests\Boolean;

use ValueObjects\Tests\TestCase;
use ValueObjects\Boolean\Boolean;

class BooleanTest extends TestCase
{
    public function testFromNative()
    {
        $boolean = Boolean::fromNative(true);
        $constructedBoolean = new Boolean(true);

        $this->assertTrue($boolean->sameValueAs($constructedBoolean));
    }

    public function testToNative()
    {
        $boolean = new Boolean(false);
        $this->assertFalse($boolean->toNative());
        
        $boolean = new Boolean(true);
        $this->assertTrue($boolean->toNative());
    }

    public function testSameValueAs()
    {
        $true1 = new Boolean(true);
        $true2 = new Boolean(true);
        $false = new Boolean(false);
    
        $this->assertTrue($true1->sameValueAs($true2));
        $this->assertTrue($true2->sameValueAs($true1));
        $this->assertFalse($true1->sameValueAs($false));
    
        $mock = $this->getMock('ValueObjects\ValueObjectInterface');
        $this->assertFalse($true1->sameValueAs($mock));
    }
    
    /** @expectedException ValueObjects\Exception\InvalidNativeArgumentException */
    public function testInvalidNativeArgument()
    {
        new Boolean(12);
    }
    
    public function testToString()
    {
        $boolean = new Boolean(false);
        $this->assertEquals('false', $boolean->__toString());
        
        $boolean = new Boolean(true);
        $this->assertEquals('true', $boolean->__toString());
    }
}
