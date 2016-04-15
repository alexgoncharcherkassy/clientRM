#!/bin/bash

clear
echo "Выберите дествие :"
echo "1 - install"
echo "2 - update"
echo "3 - create/update database"
echo "4 - quit"

read Keypress

case "$Keypress" in
1) echo "install start..."
    npm install
    composer install
    ./node_modules/.bin/bower install
    ./node_modules/.bin/gulp
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
;;
2) echo "update start..."
    npm install
    composer install
    ./node_modules/.bin/bower install
    ./node_modules/.bin/gulp
;;
3) echo "create/update database start..."
    php app/console doctrine:database:drop --force
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
;;
4) exit 0
;;
esac

exit 0
