FROM senet.azurecr.io/senet/php-fpm-apache:8.1

ARG UID
ARG GID

RUN groupadd senet -g $GID
RUN useradd senet -u $UID -g $GID -d /home/senet -m
RUN usermod -a -G www-data senet

## Install packages
RUN install-php-extensions intl amqp pdo pdo_mysql opcache mbstring && apt update && apt install -y zip

RUN a2enmod rewrite deflate expires headers
COPY .docker/apache/vhost.conf /etc/apache2/sites-enabled/000-default.conf

COPY .docker/php/conf/dev/opcache.ini $PHP_INI_DIR/conf.d/
COPY .docker/php/conf/memory.ini $PHP_INI_DIR/conf.d/
COPY .docker/php/conf/maxupload.ini $PHP_INI_DIR/conf.d/

USER senet

WORKDIR /app
