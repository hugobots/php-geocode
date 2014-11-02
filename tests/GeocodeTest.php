<?php

namespace kamranahmedse;

class GeocodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerTestGeocodeProvider
     */
    public function testGeocode($address, $expected)
    {
        $actual = new Geocode($address);

        $methods = array_keys($expected);
        foreach ($methods as $method) {
            $this->assertEquals($expected[$method], $actual->$method());
        }
    }

    public function testGeocodeProtocol()
    {
        $actual = new Geocode('', false);
        $this->assertEquals(
            'http://maps.googleapis.com/maps/api/geocode/json?sensor=false',
            $actual->getServiceUrl()
        );

        $actual = new Geocode('', true);
        $this->assertEquals(
            'https://maps.googleapis.com/maps/api/geocode/json?sensor=false',
            $actual->getServiceUrl()
        );
    }

    public function providerTestGeocodeProvider()
    {
        $providers = array();

        $providers[] = array(
                "1600 Amphitheatre Parkway, Mountain View, CA",
                array(
                    'getAddress' => '1600 Amphitheatre Parkway, Mountain View, CA',
                    'getCountry' => 'United States',
                    'getLocality' => 'Mountain View',
                    'getDistrict' => 'California',
                    'getPostcode' => '94043',
                    'getStreetAddress' => 'Amphitheatre Parkway',
                    'getStreetNumber' => '1600'
                )
            );

        $providers[] = array(
                "9 Little St, Beachburg, Ontario, Canada",
                array(
                    'getAddress' => '9 Little St, Beachburg, Ontario, Canada',
                    'getCountry' => 'Canada',
                    'getLocality' => 'Beachburg',
                    'getDistrict' => 'Ontario',
                    'getPostcode' => 'K0J 1C0',
                    'getTown' => '',
                    'getStreetNumber' => '9'
                )
            );

        return $providers;
    }
}
