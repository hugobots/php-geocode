<?php

namespace KamranAhmed\Geocode;

/**
 * Geocode
 *
 * A wrapper around Google's Geocode API that parses the address, 
 * to get different details regarding the address
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @license http://www.opensource.org/licenses/MIT
 * @version v2.0
 */
class Geocode
{
    /**
     * API URL through which the address will be obtained.
     */
    private $service_url = "://maps.googleapis.com/maps/api/geocode/json?";

    /**
     * Array containing the query results
     */
    private $service_results;
    
   /**
     * Constructor
     *
     * @param string $key Google Maps Geocoding API key
     */
    public function __construct($key = '')
    {
        $this->service_url = (!empty($key))
            ? 'https' . $this->service_url."key={$key}"
            : 'http' . $this->service_url;
    }

    /**
     * Returns the private $service_url
     * 
     * @return string The service URL
     */
    public function getServiceUrl()
    {
        return $this->service_url;
    }

    /**
     * get 
     * 
     * Sends request to the passed Google Geocode API URL and fetches the address details and returns them
     * 
     * @param  string $url Google geocode API URL containing the address or latitude/longitude
     * @return bool|object false if no data is returned by URL and the detail otherwise
     */
    public function get($address)
    {
        if ( empty($address) ) {
            throw new \Exception("Address is required in order to process");
        }

        $url= $this->getServiceUrl() . "&address=" . urlencode($address);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $service_results = json_decode(curl_exec($ch));
        if ($service_results && $service_results->status === 'OK') {
            $this->service_results = $service_results;
            return new Location($address, $this->service_results);
        }
    
        return new Location($address, new \stdClass);
    }
}
