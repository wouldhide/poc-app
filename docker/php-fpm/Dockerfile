FROM wouldhide/laravel-php-fpm:latest

COPY docker/php-fpm/local.ini /usr/local/etc/php/conf.d/
COPY / /var/www


RUN composer install

RUN php artisan config:cache 
RUN php artisan route:cache 