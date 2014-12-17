#PHP Geocode
[![Build Status](https://travis-ci.org/kamranahmedse/php-geocode.svg?branch=master)](https://travis-ci.org/kamranahmedse/php-geocode)
[![Latest Stable Version](https://poser.pugx.org/kamranahmedse/php-geocode/v/stable.svg)](https://packagist.org/packages/kamranahmedse/php-geocode)
[![License](https://poser.pugx.org/kamranahmedse/php-geocode/license.svg)](https://packagist.org/packages/kamranahmedse/php-geocode)

A wrapper around the Google Geocoding API to get different details regarding an address such as 
- Latitude/longitude
- Country
- City
- District
- Postcode
- Town
- Street number

##Requirement
PHP >= 5.3.0 and <code>curl</code> enabled server.

##Installation
You can install the library using the following ways
##Composer
The recommended installation method is through <a href="http://getcomposer.org/">Composer</a>, a dependency manager for PHP. Just add <code>kamranahmedse/php-geocode</code> to your project's <code>composer.json</code> file:

```
{
    "require": {
        "kamranahmedse/php-geocode": "*"
    }
}
```
and then run <code>composer install</code>. For further details you can find the package at <a href="https://packagist.org/packages/kamranahmedse/php-geocode">Packagist</a>.

##Manual way
Or you can install the package manually by:

- Copy <code>src/php-geocode.php</code> to your codebase, perhaps to the vendor directory.
- Add the <code>Geocode</code> class to your autoloader or require the file directly.

##Getting Started
I'm going to use the following address to explain the use of library i.e.

>1600 Amphitheatre Parkway, Mountain View, CA

Firstly, you have to instantiate the <code>Geocode</code> class and pass the address, so your code will look like
```
// Introduce the class into your scope
use kamranahmedse\Geocode;

$address = "1600 Amphitheatre Parkway, Mountain View, CA";

$geocode = new Geocode( $address );
// Optionally you can pass a second parameter set to true if you want to use https instead of http
// $geocode = new Geocode( $address, true );

// Note: All the functions below accept a parameter as a default value that will be return if the reuqired value isn't found
$geocode->getAddress( 'default value' ); 
$geocode->getLatitude(); // returns the latitude of the address
$geocode->getLongitude(); // returns the longitude of the address
$geocode->getCountry(); // returns the country of the address
$geocode->getLocality(); // returns the locality/city of the address
$geocode->getDistrict(); // returns the district of the address
$geocode->getPostcode(); // returns the postal code of the address
$geocode->getTown(); // returns the town of the address
$geocode->getStreetNumber(); // returns the street number of the address
```

##Feedback
I'd love to hear what you have to say. Please open an issue for any feature requests that you may want or the bugs that you notice. Also you can contact me at <a href="mailto:kamranahmed.se@gmail.com">kamranahmed.se@gmail.com</a> or you can also find me at twitter <a href="http://twitter.com/kamranahmed_se">@kamranahmed_se</a>


#Note
It should be noted that, the Google Geocoding API has the following limits in place and you should keep them in mind before using this wrapper:
- 2,500 requests per 24 hour period.
- 5 requests per second.

