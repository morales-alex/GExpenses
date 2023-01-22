echo 'Instalando PHP 8...'
sudo apt-get install ca-certificates apt-transport-https software-properties-common -y


sudo apt update && sudo apt install -y wget gnupg2 lsb-release
sudo wget https://packages.sury.org/php/apt.gpg && apt-key add apt.gpg
sudo echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
sudo echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
sudo wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -

sudo apt update

sudo apt-get -y install php8.1
sudo apt-get -y install php8.1-mysql

sudo rm -r /var/www/html/*
sudo cp -r /vagrant/site/* /var/www/html/
sudo cp /vagrant/php.ini /etc/php/8.1/apache2/
sudo systemctl restart apache2.service