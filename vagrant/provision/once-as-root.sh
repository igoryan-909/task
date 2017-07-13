#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

info "Allocate swap"
fallocate -l 2048M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap defaults 0 0' >> /etc/fstab

info "Configure locales"
update-locale LC_ALL="C"
dpkg-reconfigure locales

info "Configure timezone"
echo ${timezone} | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

info "Update OS software"
add-apt-repository ppa:ondrej/php -y
add-apt-repository ppa:chris-lea/redis-server -y
curl -sL https://deb.nodesource.com/setup_7.x | sudo -E bash -
touch /etc/apt/sources.list.d/pgdg.list && echo 'deb http://apt.postgresql.org/pub/repos/apt/ trusty-pgdg main' > /etc/apt/sources.list.d/pgdg.list
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | \
  apt-key add -
touch /etc/apt/sources.list.d/nginx.list \
 && echo -e "deb http://nginx.org/packages/ubuntu/ trusty nginx\ndeb-src http://nginx.org/packages/ubuntu/ trusty nginx" > /etc/apt/sources.list.d/nginx.list
wget --quiet -O - http://nginx.org/keys/nginx_signing.key | \
  apt-key add -
apt-get update
apt-get upgrade -y

info "Install additional software"
apt-get install -y git htop mc nodejs php-curl php-cli php-intl php-pgsql php-gd php-imagick php-xml php-fpm php-zmq php-mbstring php-xdebug nginx postgresql redis-server

info "Configure xdebug"
echo "xdebug.profiler_enable = 0" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.profiler_enable_trigger = 1" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.profiler_output_dir = /tmp" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_enable = 1" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_autostart=0" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_mode = req" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_host = 192.168.83.1" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_port=9000" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_handler=dbgp" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.idekey=PhpStorm1" >> /etc/php/7.1/mods-available/xdebug.ini
echo "Done!"

info "Configure PgSQL"
sed -i "s/pg_hba.conf/hba.conf/g" /etc/postgresql/9.6/main/postgresql.conf
sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '*'/g" /etc/postgresql/9.6/main/postgresql.conf
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
echo "Done!"

info "Configure NGINX"
sed -i 's/user  nginx/user  vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/conf.d/app.conf
ln -s /app/vagrant/postgresql/hba.conf /etc/postgresql/9.6/main/hba.conf
echo "Done!"

info "Initailize databases for PgSQL"
service postgresql restart
export POSTGRES_HOST='localhost'
export POSTGRES_USER='admin'
export POSTGRES_PASSWORD='kE84n$j4NdD'
export POSTGRES_CREATE_USER="CREATE USER admin WITH PASSWORD 'md5$(echo -n $POSTGRES_PASSWORD$POSTGRES_USER | md5sum | sed 's/  -//g')' SUPERUSER CREATEDB CREATEROLE REPLICATION BYPASSRLS"
psql -U postgres -c "$POSTGRES_CREATE_USER"
php /app/createdb task
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

info "Add envs into .bashrc"
echo "export POSTGRES_HOST='$POSTGRES_HOST'" >> /home/vagrant/.bashrc
echo "export POSTGRES_USER='$POSTGRES_USER'" >> /home/vagrant/.bashrc
echo "export POSTGRES_PASSWORD='$POSTGRES_PASSWORD'" >> /home/vagrant/.bashrc
