# Dockerfile for Render PHP frontend service
FROM php:8.2-apache

WORKDIR /var/www/html

# Copy application into Apache document root
COPY . .

# Install required PHP extensions for database access
RUN docker-php-ext-install mysqli pdo_mysql

# Runtime entrypoint adjusts Apache to Render-provided PORT before launching
COPY render-entrypoint.sh /usr/local/bin/render-entrypoint.sh
RUN chmod +x /usr/local/bin/render-entrypoint.sh

CMD ["render-entrypoint.sh"]
