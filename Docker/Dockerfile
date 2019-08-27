#MAINTAINER Bitfertig <mail@bitfertig.de>

# FROM php:7.0-apache
FROM php:7.3-apache-stretch

#ENV APACHE_DOCUMENT_ROOT ./www/www/
#ENV APACHE_LOG_DIR ./logs/

# utils
#RUN apt-get update && apt-get install -y apt-utils sendmail libzip-dev libpng-dev zlib1g-dev

RUN a2enmod rewrite

# remove list
RUN rm -rf /var/lib/apt/lists/*

# 000-default.conf to change apache site settings.
ADD config/000-default.conf /etc/apache2/sites-available/

# Ini
COPY config/custom.php.ini /usr/local/etc/php/

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN yes | pecl install xdebug-2.7.0 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN usermod -u 431 www-data

RUN set -eux; apt-get update; apt-get install -y libzip-dev zlib1g-dev; docker-php-ext-install zip

EXPOSE 80
#EXPOSE 443

#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
