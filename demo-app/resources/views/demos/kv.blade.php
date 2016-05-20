@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>Key / Value</h2>

        <div>
            <h3>Code</h3>
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
            <h3>Output</h3>
            <pre>{{ var_export($value) }}</pre>
        </div>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/api">&laquo; Back: API</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/locks">&raquo; Next: Locks</a>
        </div>
    </div>
</div>
