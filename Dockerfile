FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/html
COPY nginx-site.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
EXPOSE 80