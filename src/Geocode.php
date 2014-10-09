<?php

namespace kamranahmedse;

/**
 * Geocode
 *
 * A wrapper around Google's Geocode API that parses the address, 
 * to get different details regarding the address
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @license http://www.opensource.org/licenses/MIT
 * @version v1.0
 */
class Geocode
{
    /**
     * API URL through which the address will be obtained.
     */
    private $service_url = "://maps.googleapis.com/maps/api/geocode/json?sensor=false";

    /**
     * Array containing the query results
     */
    private $service_results;
    
    /**
     * Address chunks
     */
    protected $address = '';
    protected $latitude = '';
    protected $longitude = '';
    protected $country = '';
    protected $locality = '';
    protected $district = '';
    protected $postcode = '';
    protected $town = '';
    protected $streetNumber = '';
    protected $streetAddress = '';

    /**
     * Constructor
     *
     * @param string $address The address that is to be parsed
     */
    public function __construct($address, $secure_protocol = false)
    {
        $this->service_url = $secure_protocol ? 'https' . $this->service_url : 'http' . $this->service_url;
        $this->fetchAddressLatLng($address);
        
        $url = $this->getServiceUrl() . '&latlng='.$this->latitude.','.$this->longitude;
        $this->service_results = $this->fetchServiceDetails($url);
        $this->populateAddressVars();
    }

    /**
     * Returns the private $service_url
     * 
     * @return string $this->service_url
     */
    public function getServiceUrl()
    {
        return $this->service_url;
    }

    /**
     * fetchServiceDetails
     * 
     * Sends request to the passed Google Geocode API URL and fetches the address details and returns them
     * 
     * @param  string $url Google geocode API URL containing the address or latitude/longitude
     * @return bool|object false if no data is returned by URL and the detail otherwise
     */
    private function fetchServiceDetails($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $service_results = json_decode(curl_exec($ch));

        if ($service_results && $service_results->status === 'OK') {
            return $service_results;
        }

        return false;
    }

    /**
     * populateAddressVars
     * 
     * Populates the address chunks inside the object using the details returned by the service request
     * 
     */
    private function populateAddressVars()
    {
        if (!$this->service_results || !$this->service_results->results[0]) {
            return false;
        }

        foreach ($this->service_results->results[0]->address_components as $component) {
            if (in_array('street_number', $component->types)) {
                $this->streetNumber = $component->long_name;
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
            if (in_array('route', $component->types)) {
                $this->streetAddress = $component->long_name;
            }
        }
    }

    /**
     * fetchAddressLatLng
     *
     * Fetches the latitude and longitude for the address
     * 
     * @param string $address Address whose latitude and longitudes are required
     * @return mixed false if there is no address found otherwise populates the latitude and longitude for the address 
     * 
     */
    public function fetchAddressLatLng($address)
    {
        $this->address = $address;

        if (!empty($address)) {

            $tempAddress = $this->getServiceUrl() . "&address=" . urlencode($address);

            $this->service_results = $this->fetchServiceDetails($tempAddress);

            if ($this->service_results !== false) {
                $this->latitude = $this->service_results->results[0]->geometry->location->lat;
                $this->longitude = $this->service_results->results[0]->geometry->location->lng;
            }

        } else {
            return false;
        }
    }

    /**
     * getAddress
     * 
     * Returns the address if found and the default value otherwise
     * 
     * @param string $default Default address that is to be returned if the address is not found
     * @return string Default address string if no address found and the address otherwise
     */
    public function getAddress($default = '')
    {
        return $this->address ? $this->address : $default;
    }

    /**
     * getLatitude
     * 
     * Returns the latitude if found and the default value otherwise
     * 
     * @param string $default Default latitude that is to be returned if the latitude is not found
     * @return string Default latitude string if no latitude found and the latitude otherwise
     */
    public function getLatitude($default = '')
    {
        return $this->latitude ? $this->latitude : $default;
    }

    /**
     * getLongitude
     * 
     * Returns the longitude if found and the default value otherwise
     * 
     * @param string $default Default longitude that is to be returned if the longitude is not found
     * @return string Default longitude string if no longitude found and the longitude otherwise
     */
    public function getLongitude($default = '')
    {
        return $this->longitude ? $this->longitude : $default;
    }

    /**
     * getCountry
     * 
     * Returns the country if found and the default value otherwise
     * 
     * @param string $default Default country that is to be returned if the country is not found
     * @return string Default country string if no country found and the country otherwise
     */
    public function getCountry($default = '')
    {
        return $this->country ? $this->country : $default;
    }

    /**
     * getLocality
     * 
     * Returns the locality/country if found and the default value otherwise
     * 
     * @param string $default Default locality/country that is to be returned if the locality/country is not found
     * @return string Default locality/country string if no locality/country found and the locality/country otherwise
     */
    public function getLocality($default = '')
    {
        return $this->locality ? $this->locality : $default;
    }

    /**
     * getDistrict
     * 
     * Returns the district if found and the default value otherwise
     * 
     * @param string $default Default district that is to be returned if the district is not found
     * @return string Default district string if no district found and the district otherwise
     */
    public function getDistrict($default = '')
    {
        return $this->district ? $this->district : $default;
    }

    /**
     * getPostcode
     * 
     * Returns the postcode if found and the default value otherwise
     * 
     * @param string $default Default postcode that is to be returned if the postcode is not found
     * @return string Default postcode string if no postcode found and the postcode otherwise
     */
    public function getPostcode($default = '')
    {
        return $this->postcode ? $this->postcode : $default;
    }

    /**
     * getTown
     * 
     * Returns the town if found and the default value otherwise
     * 
     * @param string $default Default town that is to be returned if the town is not found
     * @return string Default town string if no town found and the town otherwise
     */
    public function getTown($default = '')
    {
        return $this->town ? $this->town : $default;
    }

    /**
     * getStreetNumber
     * 
     * Returns the getStreetNumber if found and the default value otherwise
     * 
     * @param string $default Default getStreetNumber that is to be returned if the getStreetNumber is not found
     * @return string Default getStreetNumber string if no getStreetNumber found and the getStreetNumber otherwise
     */
    public function getStreetNumber($default = '')
    {
        return $this->streetNumber ? $this->streetNumber : $default;
    }

    /**
     * getStreetAddress
     * 
     * Returns the getStreetAddress if found and the default value otherwise
     * 
     * @param string $default Default getStreetAddress that is to be returned if the getStreetAddress is not found
     * @return string Default getStreetAddress string if no getStreetAddress found and the getStreetAddress otherwise
     */
    public function getStreetAddress($default = '')
    {
        return $this->streetAddress ? $this->streetAddress : $default;
    }

    /**
     * @return string the object in string format
     */
    public function __toString()
    {
        $methods = array(
            'getAddress' => 'Address',
            'getLatitude' => 'Latitude',
            'getLongitude' => 'Longitude',
            'getCountry' => 'Country',
            'getLocality' => 'Locality',
            'getDistrict' => 'District',
            'getPostcode' => 'Postal Code',
            'getStreetAddress' => 'Street Address',
            'getStreetNumber' => 'Street Number'
        );

        $formattedString = '';
        foreach ($methods as $method => $label) {
            $formattedString .= $label.' =>'.$this->$method.'<br/>';
        }

        return $formattedString;
    }
}
