#!/bin/bash 
sudo apt update
sudo apt install -y software-properties-common
sudo apt-key adv --fetch-keys 'https://mariadb.org/mariadb_release_signing_key.asc'
sudo add-apt-repository 'deb [arch=amd64,arm64,ppc64el] https://mariadb.mirror.liquidtelecom.com/repo/10.6/ubuntu focal main'
sudo apt update && sudo apt install -y mariadb-server mariadb-client
echo 'mariadb Version: '
mariadb --version
echo 'Activación por si acaso...'
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo mariadb < /vagrant/EstructuraBBDD.sql