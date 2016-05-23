Consul SDK
==========

## Installation

This library can be installed with composer:

    composer require stevenscg/consul-php-sdk

For now, the library uses the original `SensioLabs` namespace internally.


## Usage

The simple way to use this SDK, is to instantiate the service factory:

    $sf = new SensioLabs\Consul\ServiceFactory();

Then, a service could be retrieve from this factory:

    $kv = $sf->get('kv');

Then, a service expose few methods mapped from the consul [API](https://consul.io/docs/agent/http.html):

    $kv->put('test/foo/bar', 'bazinga');
    $kv->get('test/foo/bar', ['raw' => true]);
    $kv->delete('test/foo/bar');

All services methods follow the same convention:

    $response = $service->method($mandatoryArgument, $someOptions);

* All API mandatory arguments are placed as first;
* All API optional arguments are directly mapped from `$someOptions`;
* All methods return raw Guzzle response.


## Available services

* agent
* catalog
* health
* kv
* session


## Helpers

* **Lock Handler** - Simple class that implement a distributed lock
* **DNS Helper** - Implements common service lookups via the Consul DNS.
* **Feature Flag** - Implements a feature flagging system using Consul KV.


#### Lock Handler

This helper implements distributed locks using the Consul Session and KV
services. This functionality could also be implemented using the raw Consul
services when desired.

    use SensioLabs\Consul;

    // Setup a processing lock to ensure that only one process can run at once.
    $lh = new Consul\Helper\LockHandler('locks/a-lock', true);

    // Acquire a processing lock from Consul
    $lockAcquired = $lh->lock();

    // DO SOME LONG-RUNNING TASK HERE
    // sleep(5);

    // Release the Consul processing lock
    $lh->release();


#### DNS Helper

This helper wraps the php `dns_get_record` system method and makes using
Consul DNS with applications easier.

    use SensioLabs\Consul;

    // This returns the first DNS SRV record from the local DNS
    // server managed by consul. The returned value is load-balanced
    // in real-time and should not be cached.
    $dns = new Consul\Helper\Dns();
    $result = $dns->srv('my-service.service.consul');

    // Returns the fully-qualified http/https service
    // url from the DNS managed by consul. The returned
    // value is load-balanced in real-time and should
    // not be cached.
    $result = $dns->url('my-service.service.consul');


#### Feature Flag

    use SensioLabs\Consul;

    $feature = new Consul\Helper\Feature();

    // Create a feature flag "foo" that is enabled (on = true)
    $feature->set('foo', ['on' => true]);

    // Fetch the feature object as it exists in the KV
    $item = $feature->set('foo');

    // Decode the feature object for use in a dashboard, etc.
    $decoded = $feature->decode($item);

    // Toggle some application logic based on the "foo" feature flag
    if ($feature->toggle('foo')) {
        // the "foo" feature is enabled
    } else {
        // the "foo" feature is not enabled
    }
