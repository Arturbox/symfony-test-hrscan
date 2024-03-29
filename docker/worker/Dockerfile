
FROM php:8.2-fpm-alpine


RUN apk --update add wget \
  curl \
  git \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  pcre-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  oniguruma-dev \
  openssl \
  openssl-dev \
  postgresql-dev \
  gmp \
  gmp-dev \
  libzip-dev \
  libxslt-dev \
  libzip-dev \
  ldb-dev libldap openldap-dev \
  freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev \
  supervisor

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN docker-php-ext-install dom exif gd intl opcache pdo pdo_pgsql soap xsl zip

RUN install-php-extensions bcmath decimal && mkdir -p /var/www

# Install Redis package:
ARG INSTALL_REDIS=false
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis


COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]


USER www-data
USER root

WORKDIR /etc/supervisor/conf.d/
