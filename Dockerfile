FROM php:8.2
VOLUME /code
RUN curl --version
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /code
