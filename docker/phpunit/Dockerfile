FROM php:5.6-cli

RUN apt-get update --fix-missing && apt-get install -y less vim zip curl git zlib1g-dev
RUN docker-php-ext-install zip

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#PHPUNIT
RUN composer global require "phpunit/phpunit"
ENV PATH /root/.composer/vendor/bin:$PATH
RUN ln -s /root/.composer/vendor/bin/phpunit /usr/bin/phpunit

WORKDIR /var/www/html
