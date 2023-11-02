FROM composer:latest

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ENV COMPOSERUSER=mhubuntu
ENV COMPOSERGROUP=mhubuntu
# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system ${COMPOSERGROUP}
RUN adduser -G ${COMPOSERGROUP} --system -D -s /bin/sh -u ${UID} ${COMPOSERUSER}

WORKDIR /var/www/html
