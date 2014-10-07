<?php

namespace kamranahmedse;

/**
 * Geocode
 *
 * A wrapper around Google's Geocode API that parses the address, 
 * to get different details regarding the address
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @version 0.1
 * @license http://www.opensource.org/licenses/MIT
 */
class Geocode
{
    /**
     * API URL through which the address will be obtained.
     */ 
    private $service_url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false";

    /**
     * Array containing the query results
     */
    private $service_results;
    
    protected $address = '';
    protected $latitude = '';
    protected $longitude = '';
    protected $country = '';
    protected $locality = '';
    protected $district = '';
    protected $postcode = '';
    protected $town = '';
    protected $street_number = '';

    /**
     * Constructor
     *
     * @param string $address The address that is to be parsed
     */
    public function __construct( $address = '' )
    {
        $this->fetchAddressLatLng( $address );
        
        $url = $this->service_url . '&latlng='.$this->latitude.','.$this->longitude;
        $this->service_results = $this->_fetchServiceDetails( $url );
        $this->_populateAddressVars();        
    }

    private function _fetchServiceDetails( $url )
    {
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        
        $service_results = json_decode( curl_exec($ch) );

        if ( $service_results && $service_results->status === 'OK' ) {
            return $service_results;
        }

        return false;
    }

    private function _populateAddressVars()
    {
        foreach ( $this->service_results->results[0]->address_components as $component ) {
            if (in_array('street_number', $component->types)) {
                $this->street_number = $component->long_name;
            }
            if (in_array('locality', $component->types)) {
                $this->locality = $component->long_name;
            }
            if (in_array('postal_town', $component->types)) {
                $this->town = $component->long_name;
            }
            if (in_array('administrative_area_level_2', $component->types)) {
                $this->county = $component->long_name;
            }
            if (in_array('country', $component->types)) {
                $this->country = $component->long_name;
            }
            if (in_array('administrative_area_level_1', $component->types)) {
                $this->district = $component->long_name;
            }
            if (in_array('postal_code', $component->types)) {
                $this->postcode = $component->long_name;
            }
        }
    }

    public function fetchAddressLatLng( $address )
    {
        $this->address = $address;

        if ( !empty($address) ) {

            $tempAddress = $this->service_url . "&address=" . urlencode( $address );

            $this->service_results = $this->_fetchServiceDetails( $tempAddress );

            if ( $this->service_results !== false ) {
                $this->latitude = $this->service_results->results[0]->geometry->location->lat;
                $this->longitude = $this->service_results->results[0]->geometry->location->lng;
            }

        } else {
            return false;
        }
    }

    public function getAddress ( $default = '' ) {
        return $this->address ? $this->address : $default;
    }

    public function getLatitude ( $default = '' ) {
        return $this->latitude ? $this->latitude : $default;
    }

    public function getLongitude ( $default = '' ) {
        return $this->longitude ? $this->longitude : $default;
    }

    public function getCountry ( $default = '' ) {
        return $this->country ? $this->country : $default;
    }

    public function getLocality ( $default = '' ) {
        return $this->locality ? $this->locality : $default;
    }

    public function getDistrict ( $default = '' ) {
        return $this->district ? $this->district : $default;
    }

    public function getPostcode ( $default = '' ) {
        return $this->postcode ? $this->postcode : $default;
    }

    public function getTown ( $default = '' ) {
        return $this->town ? $this->town : $default;
    }

    public function getStreetNumber ( $default = '' ) {
        return $this->street_number ? $this->street_number : $default;
    }    

    /**
     * @return string the object in string format
     */
    public function __toString()
    {
        return "address =>" . $this->address . " <br>latitude =>" . $this->latitude . " <br>longitude =>" . $this->longitude . " <br>country =>" . $this->country . " <br>district =>" . $this->district . " <br>locality =>" . $this->locality . " <br>postcode =>" . $this->postcode . " <br>town =>" . $this->town . " <br>street_number =>" . $this->street_number . " <br>";
    }
}

$obj = new Geocode( "House number P-365, Street number 7, masoodabad, near samanabad, Faisalabad, Punjab Pakistan" );
echo $obj;