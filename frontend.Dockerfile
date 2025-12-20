# Dockerfile for Render PHP frontend service
FROM php:8.2-apache

WORKDIR /var/www/html

# Copy application into Apache document root
COPY . .

# Install required PHP extensions for database access
RUN apt-get update \
	&& apt-get install -y --no-install-recommends libpq-dev \
	&& docker-php-ext-install pdo_pgsql pgsql mysqli pdo_mysql \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

# Runtime entrypoint adjusts Apache to Render-provided PORT before launching
COPY render-entrypoint.sh /usr/local/bin/render-entrypoint.sh
RUN chmod +x /usr/local/bin/render-entrypoint.sh

CMD ["render-entrypoint.sh"]
