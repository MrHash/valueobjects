<?php

namespace ValueObjects\Boolean;

use ValueObjects\ValueObjectInterface;
use ValueObjects\Util\Util;
use ValueObjects\Exception\InvalidNativeArgumentException;

class Boolean implements ValueObjectInterface
{
    private $value;

    /**
     * Returns a Boolean object given a PHP native bool as parameter.
     *
     * @param  bool $value
     * @return Boolean
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a Boolean object given a PHP native bool as parameter.
     *
     * @param bool $value
     */
    public function __construct($value)
    {
        if (false === \is_bool($value)) {
            throw new InvalidNativeArgumentException($value, array('boolean'));
        }

        $this->value = $value;
    }

    /**
     * Tells whether two objects are both boolean same value
     * @param  ValueObjectInterface $boolean
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $boolean)
    {
        if (false === Util::classEquals($this, $boolean)) {
            return false;
        }

        return $this->toNative() === $boolean->toNative();
    }

    /**
     * Returns the value of the boolean
     *
     * @return bool
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Returns a string representation of the Boolean object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->isTrue() ? 'true' : 'false';
    }
    
    /**
     * Returns the truthy value
     *
     * @return bool
     */
    public function isTrue()
    {
        return $this->toNative() === true;
    }
}
