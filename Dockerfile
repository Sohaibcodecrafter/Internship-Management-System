FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite and mod_headers for .htaccess support
RUN a2enmod rewrite headers

# Set the document root to /var/www/html (Apache default)
# Your project files will be copied here
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Rewrite hardcoded local XAMPP paths (/ims/) to root (/) for Railway
RUN find . -name "*.php" -exec sed -i 's|/ims/|/|g' {} +

# Create upload directories and set permissions
RUN mkdir -p assets/uploads/cvs \
             assets/uploads/logos \
             assets/uploads/photos \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 assets/uploads

# Custom Apache config — allow .htaccess overrides
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/ims.conf \
    && a2enconf ims

# Railway automatically routes traffic to the $PORT variable when no EXPOSE is present

# Startup script: fix Apache configuration at runtime then start
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
CMD ["/usr/local/bin/entrypoint.sh"]
