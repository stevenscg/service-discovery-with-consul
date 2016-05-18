# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "geerlingguy/centos7"
  config.ssh.insert_key = false

  # Installs any additional system packages required by
  # ansible, ansible-playbook, or ansible-galaxy.
  config.vm.provision "shell",
  path: "provision/bootstrap.sh"

  # Workaround for ansible_local and vagrant 1.8.1
  # https://github.com/mitchellh/vagrant/issues/6793
  config.vm.provision :shell, inline: <<-SCRIPT
    GALAXY=/usr/local/bin/ansible-galaxy
    echo '#!/usr/bin/env bash
    /usr/bin/ansible-galaxy "$@"
    exit 0
    ' | sudo tee $GALAXY
    sudo chmod 0755 $GALAXY
  SCRIPT

  # Run Ansible from within the Vagrant VM
  config.vm.provision "ansible_local" do |ansible|
    ansible.sudo              = true
    ansible.playbook          = "playbook.yml"
    ansible.galaxy_role_file  = "requirements.yml"
    ansible.provisioning_path = "/vagrant/provision"
  end
end
