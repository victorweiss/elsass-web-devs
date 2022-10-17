FROM php:8.1-fpm AS base_php_81

ENV WORKDIR=/var/www/app
ENV TZ=Europe/Paris

# Packages
RUN apt-get update && apt-get install -y --no-install-recommends \
	apt-utils \
	git-all \
	vim \
	nano \
	zip \
;

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
  	pdo_mysql \
  	intl \
    imagick \
    redis \
    gd \
;

# Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

COPY files/php.ini /usr/local/etc/php/conf.d/php.ini
COPY files/.bashrc /root/.bashrc

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


# ------- PHP
FROM base_php_81 AS php_81

ARG APP_ENV

COPY scripts/$APP_ENV /opt

CMD ["php-fpm"]


# ------- CRON
FROM base_php_81 AS php_81_cron

ARG APP_ENV

RUN apt-get update && apt-get install -y --no-install-recommends cron;

ADD files/crontab /etc/cron.d/crontab
RUN sed -i 's/APP_ENV/'"$APP_ENV"'/' /etc/cron.d/crontab
RUN chmod 0644 /etc/cron.d/crontab
RUN /usr/bin/crontab /etc/cron.d/crontab

CMD [ "cron", "-f" ]
