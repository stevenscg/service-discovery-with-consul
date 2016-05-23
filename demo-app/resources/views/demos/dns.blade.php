@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>DNS</h2>
        <div>
            <h3>Example 1: Pure PHP</h3>
            <h4>Code</h4>
            <pre>dns_get_record('statsd.service.consul', DNS_SRV)</pre>
        </div>
        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[0], null, '  ') }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Example 2: Consul PHP SDK</h3>
            <h4>Code</h4>
            <pre>
$dns = new Consul\Helper\Dns();

$results = [];

$results[] = $dns->srv('statsd.service.consul');
return $results;
            </pre>
        </div>
        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[1], null, '  ') }}</pre>
        </div>

        <hr/>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/">&laquo; Back: Home</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/api">Next: API &raquo;</a>
        </div>
    </div>
</div>
