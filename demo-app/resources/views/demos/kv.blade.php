@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>Key / Value</h2>

        <div>
            <h3>Example 1: <span class="label label-warning">PUT</span> /v1/kv/test/foo/bar</h3>

            <h4>Code</h4>
            <pre>
$sf = new Consul\ServiceFactory();
$kv = $sf->get('kv');

$kv->put('test/foo/bar', json_encode(['foo' => 'bar']));

$result = $kv->get('test/foo/bar');
$value  = json_decode($result->getBody(), true);

return $value;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre>{{ $jp->prettify($value, null, '  ') }}</pre>
        </div>

        <hr/>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/api">&laquo; Back: API</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/locks">Next: Locks &raquo;</a>
        </div>
    </div>
</div>
