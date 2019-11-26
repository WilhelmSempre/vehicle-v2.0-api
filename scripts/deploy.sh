#!/usr/bin/env bash

#Deployment script

environment=${environment}

while [[ $# -gt 0 ]]; do
    if [[ $1 == *"--"* ]]; then
        param="${1/--/}"
        declare ${param}="$2"
    fi

    shift
done

production (){

    git pull origin master
    git reset --hard origin/master

    php bin/console doctrine:schema:update --force --env=production

    return;
}


develop (){

    git pull origin develop
    git reset --hard origin/develop

    php bin/console doctrine:schema:update --force --env=develop

    return;
}


echo "Running deploy script. Environment: ${environment}"

echo "Installing dependencies from composer."

if [[ ${environment} == "production" ]]; then
    composer install --no-dev --optimize-autoloader

    $(production);
elif [[ ${environment} == "develop" ]]; then
    composer install --optimize-autoloader

    $(develop);
fi



