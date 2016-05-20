@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>DNS</h2>
        <div>
            <code>var_export(dns_get_record('statsd.service.consul', DNS_SRV))</code>
        </div>
        <div>
            <pre>{{ var_export(dns_get_record('statsd.service.consul', DNS_SRV)) }}</pre>
        </div>

        <div>
            <a class="btn btn-large btn-primary pull-left" href="/">&laquo; Back: Home</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/api">&raquo; Next: API</a>
        </div>
    </div>
</div>
