<?php
namespace kamranahmedse;

class LocationInfo
{
    private $address = '';
    private $latitude = '';
    private $longitude = '';
    private $country = '';
    private $locality = '';
    private $district = '';
    private $postcode = '';
    private $town = '';
    private $streetNumber = '';
    private $streetAddress = '';

    private $isValidInfo = true;

    public function __construct($address, \stdClass $dataFromGoogleMaps)
    {
        $this->address = $address;
        $this->mapKeys($dataFromGoogleMaps);
    }

    public function isValid()
    {
        return $this->isValidInfo;
    }

    private function mapKeys(\stdClass $info)
    {
        if (!property_exists($info, 'results')) {
            $this->isValidInfo = false;
            return;
        }
        $this->latitude = $info->results[0]->geometry->location->lat;
        $this->longitude = $info->results[0]->geometry->location->lng;
        foreach ($info->results[0]->address_components as $component) {
            if (in_array('street_number', $component->types)) {
                $this->streetNumber = $component->long_name;
            } elseif (in_array('locality', $component->types)) {
                $this->locality = $component->long_name;
            } elseif (in_array('postal_town', $component->types)) {
                $this->town = $component->long_name;
            } elseif (in_array('administrative_area_level_2', $component->types)) {
                $this->country = $component->long_name;
            } elseif (in_array('country', $component->types)) {
                $this->country = $component->long_name;
            } elseif (in_array('administrative_area_level_1', $component->types)) {
                $this->district = $component->long_name;
            } elseif (in_array('postal_code', $component->types)) {
                $this->postcode = $component->long_name;
            } elseif (in_array('route', $component->types)) {
                $this->streetAddress = $component->long_name;
            }
        }
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    public function getStreetAddress()
    {
        return $this->streetAddress;
    }
}
