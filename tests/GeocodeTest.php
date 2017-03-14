<?php

namespace KamranAhmed\Geocode;

class GeocodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerTestGeocodeProvider
     */
    public function testGeocode($address, $expected)
    {
        $actual   = new Geocode();
        $location = $actual->get($address);
        $methods  = array_keys($expected);
        $this->assertTrue($location->isValid());
        foreach ($methods as $method) {
            $this->assertEquals($expected[$method], $location->$method());
        }
    }

    public function testInvalidLocation()
    {
        $geo      = new Geocode();
        $location = $geo->get("House of the rights for the poor people");
        $this->assertFalse($location->isValid());
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Address is required in order to process
     */
    public function testEmptyOrNullAdress()
    {
        $actual = new Geocode();
        $actual->get("");
    }

    public function testGeocodeProtocol()
    {
        $actual = new Geocode();
        $this->assertEquals(
            'http://maps.googleapis.com/maps/api/geocode/json?',
            $actual->getServiceUrl()
        );

        $actual = new Geocode();
        $this->assertEquals(
            'http://maps.googleapis.com/maps/api/geocode/json?',
            $actual->getServiceUrl()
        );
    }

    public function testGeocodeKey()
    {
        $actual = new Geocode('DUMMYKEY');
        $this->assertEquals(
            'https://maps.googleapis.com/maps/api/geocode/json?key=DUMMYKEY',
            $actual->getServiceUrl()
        );

        $actual = new Geocode('DUMMYKEY');
        $this->assertEquals(
            'https://maps.googleapis.com/maps/api/geocode/json?key=DUMMYKEY',
            $actual->getServiceUrl()
        );
    }


    public function providerTestGeocodeProvider()
    {
        $providers = [];

        $providers[] = [
            "1600 Amphitheatre Parkway, Mountain View, CA",
            [
                'getAddress'            => '1600 Amphitheatre Parkway, Mountain View, CA',
                'getCountry'            => 'United States',
                'getShortCountry'       => 'US',
                'getLocality'           => 'Mountain View',
                'getShortLocality'      => 'Mountain View',
                'getDistrict'           => 'California',
                'getShortDistrict'      => 'CA',
                'getPostcode'           => '94043',
                'getStreetAddress'      => 'Amphitheatre Parkway',
                'getShortStreetAddress' => 'Amphitheatre Pkwy',
                'getStreetNumber'       => '1600',
            ],
        ];

        $providers[] = [
            "9 Little St, Beachburg, Ontario, Canada",
            [
                'getAddress'      => '9 Little St, Beachburg, Ontario, Canada',
                'getCountry'      => 'Canada',
                'getShortCountry' => 'CA',
                'getLocality'     => 'Beachburg',
                'getShortLocality'=> 'Beachburg',
                'getDistrict'     => 'Ontario',
                'getShortDistrict'=> 'ON',
                'getPostcode'     => 'K0J 1C0',
                'getTown'         => '',
                'getStreetNumber' => '9',
            ],
        ];

        return $providers;
    }
}
