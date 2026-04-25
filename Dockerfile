# استخدام صورة PHP 8.2 الرسمية مع خادم Apache
FROM php:8.2-apache

# تثبيت الحزم الضرورية
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd bcmath

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل Apache Rewrite Module
RUN a2enmod rewrite

# إظهار الأخطاء
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini

WORKDIR /var/www/html

# نسخ المشروع
COPY . /var/www/html

# إصلاح الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache

# تثبيت مكتبات PHP
RUN composer install --optimize-autoloader --no-dev

# إنشاء رابط التخزين
RUN php artisan storage:link

# توجيه Apache لمجلد public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# نقطة الدخول النهائية (الحل الجذري)
# هذا الأمر سيعيد بناء قاعدة البيانات من الصفر في كل مرة يُشغل فيها الموقع
# لضمان عدم وجود أي مشاكل في الصلاحيات
ENTRYPOINT ["/bin/bash", "-c", "chown -R www-data:www-data /var/www/html && rm -f database/database.sqlite && touch database/database.sqlite && chmod 666 database/database.sqlite && php artisan migrate --force && exec apache2-foreground"]