FROM alpine:latest AS builder

ARG version=1.8

ADD http://download.asternic.net/asternic-stats-${version}.tgz /app.tar.gz
RUN mkdir /app && \
    tar --dir=/app --strip-components=1 -xzvf /app.tar.gz

FROM php:7.4-cli-bullseye
LABEL author="Krzysztof Hajdamowicz"
LABEL org.opencontainers.image.source https://github.com/remedis/docker-asternic-call-center-stats-lite

COPY --from=builder /app/parselog /usr/local/bin/parselog

RUN apt-get update && apt-get install -y \
        cron \
        procps \
	&& docker-php-ext-install -j$(nproc) mysqli \
    && rm -rf /var/lib/apt/lists/*

ADD entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/sbin/cron","-f", "-l", "2"]
