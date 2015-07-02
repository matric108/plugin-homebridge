#!/bin/bash
#####Installation de nodejs v0.12 désactivée
#sudo apt-get remove -y node nodejs
#sudo rm -Rf /usr/bin/node
#sudo rm -Rf /usr/local/bin/node
#curl -sL https://deb.nodesource.com/setup_0.12 | sudo bash -
#sudo apt-get install -y nodejs
#sudo ln -s "$(which nodejs)" /usr/bin/node
#sudo ln -s "$(which nodejs)" /usr/local/bin/node

sudo apt-get install -y avahi-daemon libnss-mdns libavahi-compat-libdnssd-dev
sudo mkdir /opt
cd /opt
sudo git clone https://github.com/tmartinez69009/homebridge.git
cd homebridge
sudo git submodule init
sudo git submodule update
sudo npm install
cd lib/HAP-NodeJS
sudo npm install
sudo chown -R www-data:www-data /opt/homebridge
echo "Fin de l'installation"