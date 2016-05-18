#!/bin/sh
#
# Provisioning Shell Script for Vagrant
# @see http://docs.vagrantup.com/v2/provisioning
#
# This provisioner sets up the minimal system to
# run the application and then loads the required
# test data.
#

sudo yum -y install git
