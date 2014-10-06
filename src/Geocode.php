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
    protected $address;
    protected $latitude;
    protected $longitude;
    protected $country;
    protected $town;

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
        if ( !empty($address) ) {
            // Send a request to google API
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