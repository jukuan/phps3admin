FROM php:8.4-fpm-alpine

RUN set -eux; \
    apk add --no-cache \
        bash \
        curl && \
    rm -rf /var/cache/apk/* /usr/src/php* /tmp/*

COPY --from=composer:2.8 /usr/bin/composer /usr/local/bin/composer
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN echo "short_open_tag=On" > /usr/local/etc/php/conf.d/short_open_tag.ini

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
