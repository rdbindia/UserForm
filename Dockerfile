FROM php:8.2-apache

# Install required extensions and debugging tools
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    iputils-ping \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite (optional, for routing)
RUN a2enmod rewrite

# Copy application files to the container
COPY . /var/www/html/

# Set permissions (optional, if necessary)
RUN chown -R www-data:www-data /var/www/html

CMD ["bash", "-c", "php database/run_migrations.php"]