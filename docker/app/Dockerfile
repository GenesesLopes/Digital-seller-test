ARG PHP_IMAGE=php:7.4.4-fpm-alpine
FROM ${PHP_IMAGE}
##instalando composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#instlando pacotes auxiliares
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev nano git libpng-dev libjpeg-turbo-dev libzip-dev $PHPIZE_DEPS

##instalando e configurando pacotes para o php
RUN set -ex \
  && apk --no-cache add zip unzip tzdata
RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd
RUN docker-php-ext-install exif zip bcmath pdo_mysql

##intalando node e permissões em pastas
RUN apk add --update nodejs npm && \
mkdir /.npm && mkdir /.config && mkdir /.composer && chmod -R 777 /.composer && chmod -R 777 /.npm && chmod -R 777 /.config &&\
chmod -R 777 /usr/lib/node_modules && chmod -R 777 /usr/bin

##Alterando timezone e configurações do php para modo dev
RUN echo "America/Bahia" > /etc/TZ && cp /usr/share/zoneinfo/America/Bahia /etc/localtime && echo "America/Bahia" > /etc/timezone && \
sed "s/;date.timezone =/date.timezone = America\/Bahia/g" /usr/local/etc/php/php.ini-development  > /usr/local/etc/php/php.ini && \
sed -i "s/expose_php = On/expose_php = Off/g" /usr/local/etc/php/php.ini  

##Diretorio de trabalho
ARG APP_DIR=/var/www/html/app
WORKDIR ${APP_DIR}

EXPOSE 9000

ENTRYPOINT [ "php-fpm" ]
