echo 'Instalando PHP 8...'
sudo apt-get install ca-certificates apt-transport-https software-properties-common -y
sudo echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
sudo wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
sudo apt-get -y install php8.0
sudo apt-get -y install php-mysql
sudo apt-get install php8.0-mysql
sudo rm -r /var/www/html/*
sudo cp -a /vagrant/site/. /var/www/html/
sudo cp /vagrant/php.ini /etc/php/8.0/apache2/
sudo systemctl restart apache2.service