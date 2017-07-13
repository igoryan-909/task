#!/usr/bin/env bash

#== Import script args ==

github_token=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

info "Configure composer"
composer config --global github-oauth.github.com ${github_token}
echo "Done!"

info "Install plugins for composer"
composer global require "fxp/composer-asset-plugin:^1.2.0" --no-progress

info "Install codeception"
composer global require "codeception/codeception=2.0.*" "codeception/specify=*" "codeception/verify=*" --no-progress
echo 'export PATH=/home/vagrant/.config/composer/vendor/bin:$PATH' | tee -a /home/vagrant/.profile

info "Install project dependencies"
cd /app
composer --no-progress --prefer-dist install

info "Init project"
./init --env=Development --overwrite=y

info "Apply migrations"
export POSTGRES_HOST='localhost'
export POSTGRES_USER='admin'
export POSTGRES_PASSWORD='kE84n$j4NdD'
./yii migrate --interactive=0

./yii gii/model --tableName=user --modelClass=User --interactive=0 --ns=common\models --overwrite=1
./yii gii/model --tableName=project --modelClass=Project --interactive=0 --ns=common\models --overwrite=1
./yii gii/model --tableName=user_project --modelClass=UserProject --interactive=0 --ns=common\models --overwrite=1
./yii gii/model --tableName=note --modelClass=Note --interactive=0 --ns=common\models --overwrite=1

info "Create bash-alias 'app' for vagrant user"
echo 'alias app="cd /app"' | tee /home/vagrant/.bash_aliases

info "Enabling colorized prompt for guest console"
sed -i "s/#force_color_prompt=yes/force_color_prompt=yes/" /home/vagrant/.bashrc
