FROM alpine:latest AS builder

# Application source: PHP 8 compatible fork of Asternic Call Center Stats Lite.
# Override with --build-arg to pin a tag/commit or to use another fork.
ARG ASTERNIC_REPO=https://github.com/KrzysztofHajdamowicz/asternic-stats-lite
ARG ASTERNIC_REF=master

ADD ${ASTERNIC_REPO}/archive/${ASTERNIC_REF}.tar.gz /app.tar.gz
RUN mkdir /app && \
    tar --dir=/app --strip-components=1 -xzf /app.tar.gz

FROM php:8.5-apache
LABEL author="Krzysztof Hajdamowicz"
LABEL org.opencontainers.image.source=https://github.com/remedis/docker-asternic-call-center-stats-lite

COPY --from=builder /app/html /var/www/html

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli \
	&& rm -rf /var/lib/apt/lists/*

# Production defaults: errors go to the log (docker logs), not into the HTML.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Real client IP behind Cloudflare (cloudflared tunnel on the compose network):
# mod_remoteip rewrites the client address (REMOTE_ADDR in PHP) and the
# access log uses %a instead of %h. See remoteip.conf for details.
COPY remoteip.conf /etc/apache2/conf-available/remoteip.conf
RUN a2enmod remoteip && a2enconf remoteip

EXPOSE 80
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/ || exit 1
