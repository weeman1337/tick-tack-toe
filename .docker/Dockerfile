FROM php:7.2-apache

MAINTAINER alkomm

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /srv/app \
&& a2enmod rewrite

RUN apt-get update
RUN apt-get install -y git zip unzip