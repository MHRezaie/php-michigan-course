FROM php:8-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ENV PHPGROUP=mhubuntu
ENV PHPUSER=mhubuntu

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system ${PHPGROUP}
RUN adduser -G ${PHPGROUP} --system -D -s /bin/sh -u ${UID} ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN echo -e "http://nl.alpinelinux.org/alpine/v3.18/main\nhttp://nl.alpinelinux.org/alpine/v3.18/community" > /etc/apk/repositories
RUN docker-php-ext-install pdo pdo_mysql

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
