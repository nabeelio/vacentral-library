# vacentral-library

[![Build Status](https://travis-ci.org/nabeelio/vacentral-library.svg)](https://travis-ci.org/nabeelio/vacentral-library) [![Total Downloads](https://poser.pugx.org/nabeel/vacentral/downloads)](https://packagist.org/packages/nabeel/vacentral) [![Latest Stable Version](https://poser.pugx.org/nabeel/vacentral/v/stable)](https://packagist.org/packages/nabeel/vacentral) [![Latest Unstable Version](https://poser.pugx.org/nabeel/vacentral/v/unstable)](https://packagist.org/packages/nabeel/vacentral)

The interface to vaCentral, used in phpVMS, and can be used in your own custom system.

## installation

Installation is easiest using composer. Autoloading should take care of the rest. 

```bash
composer require nabeel/vacentral
```

## usage

```php
use VaCentral\VaCentral;

$client = new VaCentral();
$client->setApiKey('YOUR API KEY');

# Look up an airport, returns an instance of \Vacentral\Models\Airport
$airport = $client->getAirport('KJFK');

echo $airport->icao; // Will write out KJFK
```
