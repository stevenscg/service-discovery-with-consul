@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>Key / Value</h2>

        <div>
            <h3>Example 1: <span class="label label-warning">PUT</span> /v1/kv/test/foo/bar (with a string body)</h3>

            <h4>Code</h4>
            <pre>
$sf = new Consul\ServiceFactory();
$kv = $sf->get('kv');

// PUT body is a string
$kv->put('test/foo/bar', 'some string'));

$result = $kv->get('test/foo/bar');
$value  = json_decode($result->getBody(), true);

return $value;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[0], null, '  ') }}</pre>
            <pre class="pre-scrollable">{{ base64_decode($results[0][0]['Value']) }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Example 2: <span class="label label-warning">PUT</span> /v1/kv/test/foo/bazz (with JSON body)</h3>

            <h4>Code</h4>
            <pre>
$sf = new Consul\ServiceFactory();
$kv = $sf->get('kv');

// PUT body is a JSON object
$kv->put('test/foo/bazz', json_encode(['foo' => 'bar']);

$result = $kv->get('test/foo/bazz', ['raw' => true]);
$value  = json_decode($result->getBody(), true);

return $value;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $results[1] }}</pre>
            <pre class="pre-scrollable">{{ $jp->prettify($results[1], null, '  ') }}</pre>
        </div>

        <hr/>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/api">&laquo; Back: API</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/locks">Next: Locks &raquo;</a>
        </div>
    </div>
</div>
