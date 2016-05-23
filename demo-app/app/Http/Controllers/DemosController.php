<?php

namespace App\Http\Controllers;

use App\Http\Controllers;

use Camspiers\JsonPretty\JsonPretty;
use SensioLabs\Consul;

class DemosController extends Controller
{

    public function dns()
    {
        $dns = new Consul\Helper\Dns();

        $results = [];

        $results[] = dns_get_record('statsd.service.consul', DNS_SRV);
        $results[] = $dns->srv('statsd.service.consul');

        $jp = new JsonPretty;
        return view('demos.dns', compact('jp', 'results'));
    }


    public function api()
    {
        $sf = new Consul\ServiceFactory();

        $results = [];

        $catalog = $sf->get('catalog');
        $results[] = json_decode($catalog->services()->getBody(), true);

        $health = $sf->get('health');
        $results[] = json_decode($health->service('web', ['near' => '_agent', 'passing' => 1])->getBody(), true);

        $jp = new JsonPretty;
        return view('demos.api', compact('jp', 'results'));
    }


    public function kv()
    {
        $sf = new Consul\ServiceFactory();
        $kv = $sf->get('kv');

        $kv->put('test/foo/bar', json_encode(['foo' => 'bar']));
        $kv->put('test/foo/bazz', true);

        $results = [];

        $result = $kv->get('test/foo/bar');
        $results[]  = json_decode($result->getBody(), true);

        $result = $kv->get('test/foo/bazz', ['raw' => true]);
        $results[]  = json_decode($result->getBody(), true);

        $jp = new JsonPretty;
        return view('demos.kv', compact('jp', 'results'));
    }


    public function locks()
    {
        // Setup a processing lock to ensure that only one process can run at once.
        $lh = new Consul\Helper\LockHandler('locks/demo', true);

        // Acquire a processing lock from Consul
        $lockAcquired = $lh->lock();

        // DO SOME LONG-RUNNING TASK HERE
        // sleep(5);

        // Release the Consul processing lock
        $lh->release();

        $jp = new JsonPretty;
        return view('demos.locks', compact('jp', 'lockAcquired'));
    }


    public function features()
    {
        $fh = new Consul\Helper\Feature();

        $results = [];

        // Create a feature flag "foo" that is enabled (on = true)
        $results[] = $fh->set('foo', ['on' => true, 'name' => 'Foo Feature']);

        // Toggle application logic
        $results[] = $fh->toggle('foo');

        // Fetch the feature object as it exists in the KV
        $results[] = $fh->get('foo');

        // Decode the feature object for use in a dashboard, etc.
        $results[] = $fh->decode($fh->get('foo')[0]);

        $jp = new JsonPretty;
        return view('demos.features', compact('jp', 'fh', 'results'));
    }
}
