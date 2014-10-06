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
    private $service_url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=";

    /**
     * Array containing the query results
     */
    private $service_results = array();
    
    protected $address = '';
    protected $latitude = '';
    protected $longitude = '';
    protected $country = '';
    protected $town = '';

    /**
     * Constructor
     *
     * @param string $address The address that is to be parsed
     */
    public function __construct( $address = '' )
    {
        $this->fetchAddressDetail( $address );
    }

    public function fetchAddressDetail( $address )
    {
        $this->address = $address;

        if ( !empty($address) ) {

            $this->service_url .= urlencode( $address );

            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, $this->service_url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            
            $this->service_results = json_decode(curl_exec($ch), true);

        } else {
            return false;
        }
    }

    /**
     * @return string the full file name
     */
    public function __toString()
    {
        
    }
}