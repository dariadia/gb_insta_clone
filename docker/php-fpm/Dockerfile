FROM php:7.3-fpm

ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y wget git unzip \
    && docker-php-ext-install pdo_mysql \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

ADD ./php.ini /usr/local/etc/php/php.ini
ADD ./xdebug.ini /etc/php/7.3/mods-available/xdebug.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

WORKDIR /var/www/html

USER "${USER_ID}:${GROUP_ID}"

CMD ["php-fpm"]