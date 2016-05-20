# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "geerlingguy/centos7"

  config.vm.hostname = "demo"

  config.vm.network :forwarded_port, guest: 8000, host: 8000,  auto_correct: true # consul-ui
  config.vm.network :forwarded_port, guest: 8001, host: 8001,  auto_correct: true # demo-app

  # Run Ansible from the host machine to provision the VM
  config.vm.provision "ansible" do |ansible|
    ansible.sudo              = true
    ansible.playbook          = "provision/playbook.yml"
    ansible.galaxy_role_file  = "requirements.yml"
  end
end
