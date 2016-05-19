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


### Step 1: Register a service with Consul


### Step 2: Health checks


### Step 3: Integrate with the DNS interface


### Step 4: Integrate with the HTTP API


### Step 5: Key / Value Storage


### Step 6: consul-template


### Step 7: envconsul


### Step 8: Distributed locks


### Advanced Topics
