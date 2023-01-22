#!/bin/bash 
#sudo apt install -y software-properties-common
sudo apt update && sudo apt install -y mariadb-server mariadb-client
cp -f /vagrant/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
echo 'CopyPaste configuration file...'
echo 'mariadb Version: '
mariadb --version
echo 'Activación mariadb...'
sudo systemctl restart mariadb
sudo systemctl start mariadb
sudo systemctl enable mariadb
echo 'script creacion estructura BBDD'
sudo mariadb < /vagrant/estructuraBBDD.sql
echo 'script creacion usuario admin'
sudo mariadb < /vagrant/createUser.sql

