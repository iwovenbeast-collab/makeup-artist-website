FROM php:8.2-apache

# PHP extensions required by CodeIgniter and MySQL
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        unzip \
        git \
    && docker-php-ext-install \
        intl \
        mbstring \
        mysqli \
        pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies first for better Docker layer caching
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copy CodeIgniter application
COPY . .

# CodeIgniter uses /public as the web document root
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf

# Allow CodeIgniter's .htaccess to control routing
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/codeigniter.conf \
    && a2enconf codeigniter

# CodeIgniter needs writable runtime directories
RUN chown -R www-data:www-data \
        /var/www/html/writable \
        /var/www/html/public/uploads \
    && chmod -R 775 \
        /var/www/html/writable \
        /var/www/html/public/uploads

# Railway provides PORT at runtime.
EXPOSE 80

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["/usr/local/bin/docker-entrypoint.sh"]