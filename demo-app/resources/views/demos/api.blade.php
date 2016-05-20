@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>HTTP API</h2>
        <div>
            <code>file_get_contents('http://localhost:8500/v1/catalog/services')</code>
        </div>
        <div>
            <pre>{{ file_get_contents('http://localhost:8500/v1/catalog/services') }}</pre>
        </div>

        <div>
            <a class="btn btn-large btn-primary pull-left" href="/demos/dns">&laquo; Back: DNS</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/kv">&raquo; Next: Key / Value</a>
        </div>
    </div>
</div>
