#!/bin/bash -x

echo ">>> Cria SWAP"
sudo dd if=/dev/zero of=/swapfile bs=2048 count=512k
sudo mkswap /swapfile
sudo swapon /swapfile
sudo echo "/swapfile       none    swap    sw      0       0 " >> /etc/fstab
sudo chown vagrant:vagrant /swapfile
sudo chmod 0600 /swapfile
sudo mkdir -p /var/www
# Define diretivas que permitirão instalar MySQL sem perguntar senha
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

sudo cp -p /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
echo "America/Sao_Paulo" | sudo tee /etc/timezone
## Locale do sistema
echo -e "en_US.UTF-8 UTF-8\npt_BR ISO-8859-1\npt_BR.UTF-8 UTF-8" | sudo tee /var/lib/locales/supported.d/local
sudo dpkg-reconfigure locales

# Define diretiva que permitirá atualizar o grub sem ter que selecionar qual a partição de instalação (o ubuntu 14.04 atualiza o grub sozinho ao rodar 'upgrade')
# mais info>: https://github.com/mitchellh/vagrant/issues/289
echo "set grub-pc/install_devices /dev/sda" | debconf-communicate
apt-get -y -qq update
apt-get -y -qq upgrade

# Adiciona repositório PPA do PHP 5.6
#sudo add-apt-repository -y ppa:ondrej/php5 #php 5.5
sudo add-apt-repository -y ppa:ondrej/php5-5.6

# Adiciona repositório do MongoDB
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
sudo echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' | sudo tee /etc/apt/sources.list.d/mongodb.list

# Atualiza lista de pacotes
sudo apt-get update
sudo apt-get dist-upgrade -y
sudo  apt-get install -y \
build-essential \
g++ \
make \
php5 \
php5-cli \
php5-fpm \
php5-gd  \
php5-mysql \
php5-curl  \
php5-intl \
php-pear \
php5-imagick \
php5-imap \
php5-mcrypt \
php5-json \
php5-dev \
php5-redis \
redis-server \
php5-memcached \
php5-memcache \
memcached \
php5-xdebug \
php5-readline \
nginx \
vim \
curl \
wget \
mongodb-org \
php5-mongo \
mysql-server


# Configura xdebug
cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1
xdebug.max_nesting_level=250
xdebug.remote_enable=on
xdebug.remote_host=localhost
xdebug.remote_port=9000
xdebug.idekey=PHPSTORM
xdebug.remote_autostart = 1
EOF


# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo /usr/local/bin/composer self-update

echo "Configurando FPM"
sudo sed -i 's/user = www-data/user = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sudo sed -i 's/user www-data/user vagrant/g'  /etc/nginx/nginx.conf
sudo sed -i 's/group = www-data/group = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sudo sed -i 's/listen = \/var\/run\/php5-fpm.sock/listen = 127.0.0.1:9000/g' /etc/php5/fpm/pool.d/www.conf
sudo sed -i 's/cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php5/fpm/php.ini

sudo ln -s /vagrant /var/www/zf-cache
chown vagrant.vagrant /vagrant -R
# MySQL Config
sudo sed -i 's/127.0.0.1/0.0.0.0/g' /etc/mysql/my.cnf
mysql --password=root -u root --execute="GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION; FLUSH PRIVILEGES;"
service mysql restart

# MongoDB Config

# torna o mongodb acessivel a partir de qualquer lugar
sudo sed -i "s/bind_ip = .*/#bind_ip = 127.0.0.1/" /etc/mongod.conf
# Habilita Text Search
echo "setParameter = textSearchEnabled=true" | sudo tee -a /etc/mongod.conf
sudo service mongod restart


# PHP Config

# Exiba todos os erros
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/fpm/php.ini
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/fpm/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/cli/php.ini

# Aumenta a quantidade limite de memória
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php5/fpm/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php5/cli/php.ini

# Aumenta o tempo máximo de execução de cada script
sudo sed -i "s/max_execution_time = .*/max_execution_time = 120/" /etc/php5/fpm/php.ini
sudo sed -i "s/max_execution_time = .*/max_execution_time = 120/" /etc/php5/cli/php.ini

# Não expoe a versão do PHP no header da response.
sudo sed -i "s/expose_php = .*/expose_php = Off/" /etc/php5/fpm/php.ini
sudo sed -i "s/expose_php = .*/expose_php = Off/" /etc/php5/cli/php.ini

# tempo que o servidor guarda os dados da sessão antes de enviar para o Garbage Collection
sudo sed -i "s/session.cookie_lifetime = .*/session.cookie_lifetime = 172800/" /etc/php5/fpm/php.ini # 2 dias em segundos
sudo sed -i "s/session.cookie_lifetime = .*/session.cookie_lifetime = 172800/" /etc/php5/cli/php.ini # 2 dias em segundos

# tempo de expiração do cookie PHPSSESIONID
sudo sed -i "s/gc_maxlifetime = .*/gc_maxlifetime = 172800/" /etc/php5/fpm/php.ini # 2 dias em segundos
sudo sed -i "s/gc_maxlifetime = .*/gc_maxlifetime = 172800/" /etc/php5/cli/php.ini # 2 dias em segundos

# TIMEZONE == O -r a baixo é pro sed aceitar ?: http://stackoverflow.com/questions/6156259/sed-expression-dont-allow-optional-grouped-string
sudo sed -r -i "s,;?date.timezone =.*,date.timezone = America/Sao_Paulo" /etc/php5/fpm/php.ini
sudo sed -r -i "s,;?date.timezone =.*,date.timezone = America/Sao_Paulo" /etc/php5/cli/php.ini

# Habilita short open tags (<? ?>)
sudo sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php5/fpm/php.ini
sudo sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php5/cli/php.ini

# Aumenta o tamanho máximo dos uploads para 100MB
sudo sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php5/fpm/php.ini # 2 dias em segundos
sudo sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php5/cli/php.ini # 2 dias em segundos
sudo sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php5/fpm/php.ini # 2 dias em segundos
sudo sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php5/cli/php.ini # 2 dias em segundos

# Opcache - configs recomendadas pelo manual do PHP: http://php.net/manual/en/opcache.installation.php
cat << EOF | sudo tee -a /etc/php5/mods-available/opcache.ini
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=0
opcache.enable=0
EOF

sudo unlink /etc/nginx/sites-enabled/default
sudo cp /vagrant/config/default /etc/nginx/sites-enabled/
sudo cp /vagrant/config/cache /etc/nginx/sites-enabled/

sudo wget http://phpmemcacheadmin.googlecode.com/files/phpMemcachedAdmin-1.2.2-r262.tar.gz
sudo mkdir -p /var/www/cache
sudo tar -zxf phpMemcachedAdmin-1.2.2-r262.tar.gz -C /var/www/cache
sudo rm phpMemcachedAdmin-1.2.2-r262.tar.gz
sudo chmod +rx /var/www/cache/*
sudo chmod 0777 /var/www/cache/Config/Memcache.php
sudo chmod 0777 /var/www/cache/Temp/

sudo service php5-fpm restart
sudo service nginx restart
sudo mysqladmin -u root -proot create zf-cache
php /var/www/zf-cache/public/index.php orm:schema-tool:create
php /var/www/zf-cache/public/index.php odm:schema:create

# Ao efetuar login (vagrant ssh), já entra no diretório '/vagrant'
echo "cd /var/www/" | sudo tee -a /home/vagrant/.bashrc
