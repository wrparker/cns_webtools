mkdir bootstrap/cache/;
composer install;
#cp .env.example .env;
php artisan key:generate;
bash fix-permissions.bash

