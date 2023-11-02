FROM nginx:stable-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ENV NGINXUSER=mhubuntu
ENV NGINXGROUP=mhubuntu

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system ${NGINXGROUP}
RUN adduser -G ${NGINXGROUP} --system -D -s /bin/sh -u ${UID} ${NGINXUSER}
RUN sed -i "s/user  nginx/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html