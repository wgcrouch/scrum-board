ItsAllAgile
===========

Online scrum/agile application with javascript scrumboard. 


Setup instructions:
-------------------

Clone

Copy app/config/parameters.ini.dist to app/config/parameters.ini

Create an empty database

Update parameters.ini with your database config

From the root folder run "php bin/composer.phar install" to pull in all deps

Then run "php app/console doctrine:migrations:migrate"

Then run "php app/console assets:install --symlink web" to symlink the css and js for all bundles into the web folder

Set up a vhost if ncessary



Node Setup for web socket stuff:
-----------
Install nodejs (Fedora version here http://nodejs.tchol.org/)

In the root folder of the app run "npm install socket.io"

To start the socket server run "nodejs node-server/server.js"

Optionally install supervisord to keep the server running and add this to /etc/supervisord.conf

    [program:scrum-node]
    command=/usr/bin/nodejs /home/wcrouch/web/scrum-board/node-server/server.js  #Update with your apps location
    user=apache #The user you want to run it as

