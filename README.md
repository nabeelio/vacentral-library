# vacentral-library

[![Build Status](https://travis-ci.org/nabeelio/vacentral-library.svg)](https://travis-ci.org/nabeelio/vacentral-library) [![Total Downloads](https://poser.pugx.org/nabeel/vacentral/downloads)](https://packagist.org/packages/nabeel/vacentral) [![Latest Stable Version](https://poser.pugx.org/nabeel/vacentral/v/stable)](https://packagist.org/packages/nabeel/vacentral) [![Latest Unstable Version](https://poser.pugx.org/nabeel/vacentral/v/unstable)](https://packagist.org/packages/nabeel/vacentral)

The interface to vaCentral, used in phpVMS, and can be used in your own custom system.

## installation

Installation is easiest using composer. Autloading should take care of the rest. 

```bash
composer require nabeel/vacentral
```

## usage

```php
use VaCentral\VaCentral;

VaCentral::setApiKey('YOUR API KEY');

# Look up an airport
$airport = \VaCentral\Airport::get('KJFK');
```

Which will return an object:

```json
{
   "id":"KJFK",
   "iata":"JFK",
   "icao":"KJFK",
   "name":"John F Kennedy International Airport",
   "city":"New York",
   "country":"United States",
   "tz":"America\/New_York",
   "lat":"40.63980103",
   "lon":"-73.77890015"
}
```
