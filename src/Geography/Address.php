<?php

namespace ValueObjects\Geography;

use ValueObjects\Util\Util;
use ValueObjects\ValueObjectInterface;
use ValueObjects\String\String;

class Address implements ValueObjectInterface
{
    /**
     * Name of the addressee (natural person or company)
     * @var String
     */
    protected $name;

    /** @var Street */
    protected $street;

    /**
     * District/City area
     * @var String
     */
    protected $district;

    /**
     * City/Town/Village
     * @var String
     */
    protected $city;

    /**
     * Region/County/State
     * @var String
     */
    protected $region;

    /**
     * Postal code/P.O. Box/ZIP code
     * @var String
     */
    protected $postalCode;

    /** @var Country */
    protected $country;

    /**
     * Returns a new Address from native PHP arguments
     *
     * @param  string                  $name
     * @param  string                  $street_name
     * @param  string                  $street_number
     * @param  string                  $district
     * @param  string                  $city
     * @param  string                  $region
     * @param  string                  $postal_code
     * @param  string                  $country_code
     * @return self
     * @throws \BadMethodCallException
     */
    public static function fromNative()
    {
        $args = \func_get_args();

        if (\count($args) != 8) {
            throw new \BadMethodCallException('You must provide exactly 8 arguments: 1) addressee name, 2) street name, 3) street number, 4) district, 5) city, 6) region, 7) postal code, 8) country code.');
        }

        $name       = new String($args[0]);
        $street     = new Street(new String($args[1]), new String($args[2]));
        $district   = new String($args[3]);
        $city       = new String($args[4]);
        $region     = new String($args[5]);
        $postalCode = new String($args[6]);
        $country    = Country::fromNative($args[7]);

        return new static($name, $street, $district, $city, $region, $postalCode, $country);
    }

    /**
     * Returns a new Address object
     *
     * @param String  $name
     * @param Street  $street
     * @param String  $district
     * @param String  $city
     * @param String  $region
     * @param String  $postalCode
     * @param Country $country
     */
    public function __construct(String $name, Street $street, String $district, String $city, String $region, String $postalCode, Country $country)
    {
        $this->name       = $name;
        $this->street     = $street;
        $this->district   = $district;
        $this->city       = $city;
        $this->region     = $region;
        $this->postalCode = $postalCode;
        $this->country    = $country;
    }

    /**
     * Tells whether two Address are equal
     *
     * @param  ValueObjectInterface $address
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $address)
    {
        if (false === Util::classEquals($this, $address)) {
            return false;
        }

        return $this->getName()->sameValueAs($address->getName())             &&
               $this->getStreet()->sameValueAs($address->getStreet())         &&
               $this->getDistrict()->sameValueAs($address->getDistrict())     &&
               $this->getCity()->sameValueAs($address->getCity())             &&
               $this->getRegion()->sameValueAs($address->getRegion())         &&
               $this->getPostalCode()->sameValueAs($address->getPostalCode()) &&
               $this->getCountry()->sameValueAs($address->getCountry())
        ;
    }

    /**
     * Returns addressee name
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns street
     *
     * @return Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Returns district
     *
     * @return String
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Returns city
     *
     * @return String
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Returns region
     *
     * @return String
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Returns postal code
     *
     * @return String
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Returns country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Returns a string representation of the Address in US standard format.
     *
     * @return string
     */
    public function __toString()
    {
        $format = <<<ADDR
%s
%s
%s %s %s
%s
ADDR;

        $addressString = \sprintf($format, $this->getName(), $this->getStreet(), $this->getCity(), $this->getRegion(), $this->getPostalCode(), $this->getCountry());

        return $addressString;
    }
}
