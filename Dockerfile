FROM php:8.2-apache

# =========================
# تثبيت المتطلبات
# =========================
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        gd \
        bcmath

# =========================
# Composer
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================
# Apache config
# =========================
RUN a2enmod rewrite

# جعل public هو root
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# =========================
# إعداد المشروع
# =========================
WORKDIR /var/www/html
COPY . .

# صلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# تثبيت Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# =========================
# أهم جزء: دعم PORT الخاص بـ Render
# =========================
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf \
    /etc/apache2/sites-available/000-default.conf

# =========================
# تشغيل Apache
# =========================
CMD ["sh", "-c", "apache2-foreground"]