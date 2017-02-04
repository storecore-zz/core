FROM php:5.6.30-fpm-alpine
MAINTAINER Tristan van Bokkem <tristan@storecore.org>

# Install mysql extension
RUN docker-php-ext-install pdo_mysql

# Add additional PHP configuration files
COPY conf/999-php.ini /usr/local/etc/php/conf.d/999-php.ini
COPY conf/www.conf /etc/php5/fpm/pool.d/www.conf
COPY conf/php-fpm.conf /etc/php5/fpm/php-fpm.conf

# Copy the StoreCore code to the Docker image
COPY . /app

# Clean-up
RUN rm -r /app/conf
RUN rm /app/Dockerfile
RUN rm /app/.dockerignore

# Configure permissions
RUN chown -R www-data:www-data /app

# Setup our working directory
WORKDIR /app

# Announce ourself on port 9000
EXPOSE 9000

# Run php-fpm in foreground
CMD ["php-fpm", "-F"]
