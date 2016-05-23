@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>Feature Flags</h2>

        <div>
            <h3>Step 1: Create a feature flag</h3>

            <h4>Code</h4>
            <pre>
$fh = new Consul\Helper\Feature();

// Create a feature flag "foo" that is enabled (on = true)
$result = $fh->set('foo', ['on' => true, 'name' => 'Foo Feature']);

return $result;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[0], null, '  ') }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Step 2: Toggle application logic</h3>

            <h4>Code</h4>
            <pre>
$fh = new Consul\Helper\Feature();

// Toggle application logic based on the "foo" feature flag
if ($fh->toggle('foo')) {
    // the "foo" feature is enabled
} else {
    // the "foo" feature is not enabled
}
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[1], null, '  ') }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Fetch the feature flag object</h3>

            <h4>Code</h4>
            <pre>
$fh = new Consul\Helper\Feature();

// Fetch the feature object as it exists in the KV
$result = $fh->get('foo');

return $result;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[2], null, '  ') }}</pre>
        </div>

        <hr/>

        <div>
            <h3>Decode the feature object</h3>

            <h4>Code</h4>
            <pre>
$fh = new Consul\Helper\Feature();

// Decode the feature object for use in a dashboard, etc.
$result = $fh->decode($fh->get('foo')[0]);

return $result;
            </pre>
        </div>

        <div>
            <h4>Output</h4>
            <pre class="pre-scrollable">{{ $jp->prettify($results[3], null, '  ') }}</pre>
        </div>

        <hr/>


        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/locks">&laquo; Back: Locks</a>
            <a class="btn btn-large btn-primary pull-right" href="/">Start Over &raquo;</a>
        </div>
    </div>
</div>
