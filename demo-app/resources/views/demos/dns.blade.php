@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>DNS</h2>
        <div>
            <h3>Code</h3>
            <pre>var_export(dns_get_record('statsd.service.consul', DNS_SRV))</pre>
            <pre>var_export(dns_get_record('cache.service.consul', DNS_SRV))</pre>
        </div>
        <div>
            <h3>Output</h3>
            <pre>{{ var_export(dns_get_record('statsd.service.consul', DNS_SRV)) }}</pre>
            <pre>{{ var_export(dns_get_record('cache.service.consul', DNS_SRV)) }}</pre>
        </div>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/">&laquo; Back: Home</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/api">&raquo; Next: API</a>
        </div>
    </div>
</div>
