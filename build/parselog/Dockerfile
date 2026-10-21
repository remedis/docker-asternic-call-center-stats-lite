FROM alpine:latest AS builder

# Application source: PHP 8 compatible fork of Asternic Call Center Stats Lite.
# Override with --build-arg to pin a tag/commit or to use another fork.
ARG ASTERNIC_REPO=https://github.com/KrzysztofHajdamowicz/asternic-stats-lite
ARG ASTERNIC_REF=master

ADD ${ASTERNIC_REPO}/archive/${ASTERNIC_REF}.tar.gz /app.tar.gz
RUN mkdir /app && \
    tar --dir=/app --strip-components=1 -xzf /app.tar.gz

FROM php:8.5-cli
LABEL author="Krzysztof Hajdamowicz"
LABEL org.opencontainers.image.source=https://github.com/remedis/docker-asternic-call-center-stats-lite

COPY --from=builder /app/parselog /usr/local/bin/parselog

RUN apt-get update && apt-get install -y \
        cron \
        procps \
	&& docker-php-ext-install -j$(nproc) mysqli \
    && rm -rf /var/lib/apt/lists/*

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

ADD entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/sbin/cron","-f", "-l", "2"]
