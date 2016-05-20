# Service Discovery with Consul

This repository provides a Vagrant environment with Consul and supporting tools
installed that can be used to demonstrate many aspects of service discovery and
other features of Consul.


### Prerequisites
* Vagrant
* Virtualbox
* Ansible
* git


### Install Ansible and Virtualbox

If Vagrant and Virtualbox do not already exist on the host machine, install them now.

Ansible must be installed on the host machine to provision the VM and also to perform
each of the demonstration steps post-provisioning.

For MacOS:
```
sudo pip install ansible
```

Other platforms, see the [installation documentation](http://docs.ansible.com/ansible/intro_installation.html).


### Launch and provision the VM

From the host machine:
```
vagrant up
```

This installs a CentOS 7 base image plus the following:
* nginx
* supervisor
* consul
* dnsmasq

See the provisioning playbook (`provision/playbook.yml`) for the roles and configuration items
used to bootstrap the VM.

The Vagrantfile instructs the required ansible roles from `requirements.yml` to be downloaded
prior to the start of provisioning.


### Explore

At this stage, the VM features a Consul-enabled service discovery environment with:
* A single node Consul cluster,
* DNS on the `.consul` domain is handled by Consul via dnsmasq,
* The Consul open-source UI is available from the host machine at `http://localhost:8000/ui`,
* The Consul agent available via the commandline,
* The Consul HTTP API available via `http://localhost:8500` from within the VM.

<hr/>

## Demos

This section provides step by step demonstrations of a key service discovery features and
capabilities.


### Step 1: Services

Ansible:
```
ansible-playbook 01-register-service.yml -i .vagrant/provisioners/ansible/inventory
```

CURL:
```
# Register statsd and our demo-app (web) services and associated checks.
curl -q -X PUT http://localhost:8500/v1/agent/service/register --header "Content-Type:application/json" -d '{
  "ID": "statsd",
  "Name": "statsd",
  "Address": "127.0.0.1",
  "Port": 8125,
  "Check": {
    "Script": "echo stats | nc localhost 8126",
    "Interval": "30s"
  }
}'

curl -q -X PUT http://localhost:8500/v1/agent/service/register --header "Content-Type:application/json" -d '{
  "ID": "web",
  "Name": "web",
  "Address": "127.0.0.1",
  "Port": 8001,
  "Check": {
    "HTTP": "http://localhost:8001/health_check",
    "Interval": "10s"
  }
}'

# View the updated services
curl http://localhost:8500/v1/agent/services | jq .
```


### Step 2: Health checks

Ansible:
```
ansible-playbook 02-register-health-checks.yml -i .vagrant/provisioners/ansible/inventory
```

CURL:
```
# View existing checks (from step 1, etc)
curl http://localhost:8500/v1/agent/checks | jq .

# Register a check for the demo-app (web)
curl -q -X PUT http://localhost:8500/v1/agent/check/register --header "Content-Type:application/json" -d '{
  "ID": "service:web:status_code",
  "Name": "service:web:status_code",
  "HTTP": "http://localhost:8001",
  "Interval": "10s"
}'

# View the updated health checks
curl http://localhost:8500/v1/agent/services | jq .
```


### Step 3: Integrate with the DNS interface

See how the demo application uses Consul DNS to lookup the `statsd` service:
```
http://localhost:8001/demos/dns
```


### Step 4: Integrate with the HTTP API

See how the demo application uses Consul HTTP API to lookup the current registered services:
```
http://localhost:8001/demos/api
```


### Step 5: Key / Value Storage


### Step 6: consul-template


### Step 7: envconsul


### Step 8: Distributed locks


### Advanced Topics
