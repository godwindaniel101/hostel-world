FROM php:7.3-apache

# Install PHP
RUN apt-get update && apt-get install -y \
    curl \
    zlib1g-dev \
    libzip-dev \
    nano

# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install zip

WORKDIR /var/www/html

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN service apache2 restart

