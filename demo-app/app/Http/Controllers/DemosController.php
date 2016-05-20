<?php

namespace App\Http\Controllers;

use App\Http\Controllers;

use SensioLabs\Consul;

class DemosController extends Controller
{

    public function dns()
    {
        return view('demos.dns');
    }


    public function api()
    {
        return view('demos.api');
    }


    public function kv()
    {
        $sf = new Consul\ServiceFactory();
        $kv = $sf->get('kv');

        $kv->put('test/foo/bar', json_encode(['foo' => 'bar']));

        $result = $kv->get('test/foo/bar');
        $value  = json_decode($result->getBody(), true);

        return view('demos.kv', compact('value'));
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

        return view('demos.locks', compact('lockAcquired'));
    }
}
