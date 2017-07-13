#!/usr/bin/env bash

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

export

#== Provision script ==

info "Creating env vars"

export POSTGRES_HOST='localhost'
export POSTGRES_USER='admin'
export POSTGRES_PASSWORD='kE84n$j4NdD'
