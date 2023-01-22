echo 'Instalando APACHE...'
sudo apt-get -y install apache2
sudo ufw app list
sudo ufw allow 'WWW'
sudo systemctl status apache2
sudo apt install curl
sudo curl -4 icanhazip.com