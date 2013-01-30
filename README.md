[![Build Status](https://secure.travis-ci.org/wgcrouch/scrum-board.png?branch=master)](https://travis-ci.org/wgcrouch/scrum-board)

ItsAllAgile
===========

Online scrum/agile application with javascript scrumboard. 

Requirements
------------
PHP > 5.4

NodeJs

MongoDb

Setup instructions:
-------------------

Clone into a directory

Copy app/config/parameters.yml.dist to app/config/parameters.yml

Update parameters.yml with your mongo config

From the root folder run "php bin/composer.phar install" to pull in all deps

Then run "php app/console doctrine:mongodb:schema:create" and "php app/console doctrine:mongodb:fixtures:load" to setup the mongo database with some initial data

Then run 
"php app/console assetic:dump" and
"php app/console assets:install --symlink web" to symlink the css and js for all bundles into the web folder

Set up a vhost if ncessary

Node Setup for web socket stuff:
-----------

Install nodejs

In the root folder of the app run "npm install socket.io"

To start the socket server run "node node-server/server.js"

