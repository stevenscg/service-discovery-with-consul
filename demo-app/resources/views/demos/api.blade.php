@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>HTTP API</h2>

        <div>
            <h3>Example 1: <span class="label label-primary">GET</span> /v1/catalog/services</h3>

            <h4>Code</h4>
            <pre>
$sf = new Consul\ServiceFactory();

$results = [];

$catalog = $sf->get('catalog');
$results[] = json_decode($catalog->services()->getBody(), true);

return $results;
            </pre>
        </div>
        <div>
            <h4>Output</h4>
            <pre>{{ $jp->prettify($results[0], null, '  ') }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Example 2: <span class="label label-primary">GET</span> /v1/health/service/cache?near=_agent&passing</h3>

            <h4>Code</h4>
            <pre>
$sf = new Consul\ServiceFactory();

$results = [];

$health = $sf->get('health');
$results[] = json_decode($health->service('cache', ['passing'])->getBody(), true);

return $results;
            </pre>
        </div>
        <div>
            <h4>Output</h4>
            <pre>{{ $jp->prettify($results[1], null, '  ') }}</pre>
        </div>

        <hr/>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/dns">&laquo; Back: DNS</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/kv">Next: Key / Value &raquo;</a>
        </div>
    </div>
</div>
