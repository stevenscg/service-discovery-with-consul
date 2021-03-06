@extends('layouts.default')

<div class="container">
    <div class="row">
        <h2>Distributed Locks</h2>

        <div>
            <h3>Code</h3>
            <pre>
// Setup a processing lock to ensure that only one process can run at once.
$lh = new Consul\Helper\LockHandler('locks/demo', true);

// Acquire a processing lock from Consul
$lh->lock();

// DO SOME LONG-RUNNING TASK HERE

// Release the Consul processing lock
$lh->release();
            </pre>
        </div>

        <div>
            <h3>Output</h3>
            <p>Lock Acquired: {{ $lockAcquired }}</p>
        </div>

        <hr/>

        <div class="page-nav">
            <a class="btn btn-large btn-primary pull-left" href="/demos/locks">&laquo; Back: Locks</a>
            <a class="btn btn-large btn-primary pull-right" href="/demos/features">Next: Feature Flags &raquo;</a>
        </div>
    </div>
</div>
