@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>HTTP API</h2>
        <div>
            <h3>Code</h3>
            <pre>file_get_contents('http://localhost:8500/v1/catalog/services')</pre>
            <pre>file_get_contents('http://localhost:8500/v1/health/service/cache?passing')</pre>
        </div>
        <div>
            <h3>Output</h3>
            <pre>{{ file_get_contents('http://localhost:8500/v1/catalog/services') }}</pre>
            <pre>{{ file_get_contents('http://localhost:8500/v1/health/service/cache?passing') }}</pre>
        </div>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/dns">&laquo; Back: DNS</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/kv">&raquo; Next: Key / Value</a>
        </div>
    </div>
</div>
