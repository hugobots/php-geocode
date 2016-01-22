<?php
namespace KamranAhmed\Geocode;

/**
 * Location
 *
 * Represents the location details obtained from the Geocoding
 * Service
 */
class Location
{
    /** @var string Address to which the detail belong */
    private $address = '';

    /** @var string Latitude of the location */
    private $latitude = '';

    /** @var string Longitude of the location */
    private $longitude = '';

    /** @var string Country of the location */
    private $country = '';

    /** @var string Locality of the location */
    private $locality = '';

    /** @var string District of the location */
    private $district = '';

    /** @var string Postal code of the location */
    private $postcode = '';

    /** @var string Town of the location */
    private $town = '';

    /** @var string Street number */
    private $streetNumber = '';

    /** @var string Street address */
    private $streetAddress = '';

    /** @var boolean Whether the location is valid or not */
    private $isValid = true;

    /**
     * Create a new Location object
     * @param string    $address         Address whose detail it is
     * @param \stdClass $dataFromService The data retrieved from the Geocoding service
     */
    public function __construct($address, \stdClass $dataFromService)
    {
        $this->address = $address;
        $this->populateDetail($dataFromService);
    }

    /**
     * Checks whether the data passed to the class was valid
     * @return boolean True if the data is valid and false otherwise
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Populates the object with the detail from the service
     * @param  \stdClass $locationDetail The address detail i.e. which was retrieved from the API
     * @return boolean          True if successfuly populated the detail and false otherwise
     */
    private function populateDetail(\stdClass $locationDetail)
    {
        // The data from the API is returned under the `results` key
        if (!property_exists($locationDetail, 'results')) {
            $this->isValid = false;
            return false;
        }

        $this->latitude = $locationDetail->results[0]->geometry->location->lat;
        $this->longitude = $locationDetail->results[0]->geometry->location->lng;

        foreach ($locationDetail->results[0]->address_components as $component) {

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

        return true;
    }

    /**
     * Gets the address
     * @return string
     */
    public function getAddress($default = '')
    {
        return $this->address ?: $default;
    }

    /**
     * Gets the latitude of the location
     * @return string
     */
    public function getLatitude($default = '')
    {
        return $this->latitude ?: $default;
    }

    /**
     * Gets the longitude of the location
     * @return string
     */
    public function getLongitude($default = '')
    {
        return $this->longitude ?: $default;
    }

    /**
     * Gets the country of the location
     * @return string
     */
    public function getCountry($default = '')
    {
        return $this->country ?: $default;
    }

    /**
     * Gets the locality of the location
     * @return string
     */
    public function getLocality($default = '')
    {
        return $this->locality ?: $default;
    }

    /**
     * Gets the district of the location
     * @return string
     */
    public function getDistrict($default = '')
    {
        return $this->district ?: $default;
    }

    /**
     * Gets the post code for the location
     * @return string
     */
    public function getPostcode($default = '')
    {
        return $this->postcode ?: $default;
    }

    /**
     * Gets the town for the location
     * @return string
     */
    public function getTown($default = '')
    {
        return $this->town ?: $default;
    }

    /**
     * Gets the street number for the location
     * @return string
     */
    public function getStreetNumber($default = '')
    {
        return $this->streetNumber ?: $default;
    }

    /**
     * Gets the street address
     * @return string
     */
    public function getStreetAddress($default = '')
    {
        return $this->streetAddress ?: $default;
    }
}
