@extends('layouts.default')

<div class="jumbotron">
  <div class="container">
    <h1>Service Discovery with Consul</h1>
    <p>This application demonstrates using various Consul features for service discovery.</p>
    <p><a class="btn btn-primary btn-lg" href="/demos/dns" role="button">Get started &raquo;</a></p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <h2>DNS</h2>
      <p>Uses the Consul DNS for dependent services.</p>
      <p><a class="btn btn-default" href="demos/dns" role="button">View details &raquo;</a></p>
    </div>
    <div class="col-md-4">
      <h2>API</h2>
      <p>Uses the Consul HTTP API for dependent services.</p>
      <p><a class="btn btn-default" href="demos/api" role="button">View details &raquo;</a></p>
   </div>
    <div class="col-md-4">
      <h2>Key / Value</h2>
      <p>Demonstrates use of the Consul Key / Value store.</p>
      <p><a class="btn btn-default" href="demos/kv" role="button">View details &raquo;</a></p>
    </div>

  <div class="row">
    <div class="col-md-4">
      <h2>Distributed Locks</h2>
      <p>Uses the Consul session and KV for locks.</p>
      <p><a class="btn btn-default" href="demos/locks" role="button">View details &raquo;</a></p>
    </div>
  </div>

</div> <!-- /container -->
