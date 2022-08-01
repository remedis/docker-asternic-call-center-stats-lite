FROM alpine:latest AS builder

ARG version=1.8

ADD http://download.asternic.net/asternic-stats-${version}.tgz /app.tar.gz
RUN mkdir /app && \
    tar --dir=/app --strip-components=1 -xzvf /app.tar.gz

FROM php:7.4-apache-bullseye
LABEL author="Krzysztof Hajdamowicz"
LABEL org.opencontainers.image.source https://github.com/remedis/docker-asternic-call-center-stats-lite

COPY --from=builder /app/html /var/www/html

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli \
	&& rm -rf /var/lib/apt/lists/*

RUN a2enmod remoteip && \
	echo 'RemoteIPHeader X-Real-IP' > /etc/apache2/conf-available/remoteip.conf && \
	echo 'RemoteIPInternalProxy 172.0.0.0/8' >> /etc/apache2/conf-available/remoteip.conf && \
	a2enconf remoteip

EXPOSE 80
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/ || exit 1
