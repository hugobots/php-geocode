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
    private $serviceUrl = "://maps.googleapis.com/maps/api/geocode/json?";

    /**
     * Array containing the query results
     */
    private $serviceResults;
    
   /**
     * Constructor
     *
     * @param string $key Google Maps Geocoding API key
     */
    public function __construct($key = '')
    {
        $this->serviceUrl = (!empty($key))
            ? 'https' . $this->serviceUrl."key={$key}"
            : 'http' . $this->serviceUrl;
    }

    /**
     * Returns the private $serviceUrl
     *
     * @return string The service URL
     */
    public function getServiceUrl()
    {
        return $this->serviceUrl;
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
        if (empty($address)) {
            throw new \Exception("Address is required in order to process");
        }

        $url= $this->getServiceUrl() . "&address=" . urlencode($address);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $serviceResults = json_decode(curl_exec($ch));
        if ($serviceResults && $serviceResults->status === 'OK') {
            $this->serviceResults = $serviceResults;
            return new Location($address, $this->serviceResults);
        }
    
        return new Location($address, new \stdClass);
    }
}
