# استخدام صورة PHP 8.2 الرسمية مع خادم Apache
FROM php:8.2-apache

# تثبيت الحزم الضرورية من النظام (System dependencies)
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
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd bcmath

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل Apache Rewrite Module (ضروري لعمل الروابط في Laravel)
RUN a2enmod rewrite

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الحاوية
COPY . /var/www/html

# حل مشكلة الصلاحيات (Permissions) لإصلاح خطأ 500
# منح Apache صلاحيات الكتابة للمجلدات الحيوية
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage/logs \
    && chmod -R 775 /var/www/html/storage/framework \
    && chmod -R 775 /var/www/html/storage/app

# تثبيت مكتبات PHP وتحسين الأداء
RUN composer install --optimize-autoloader --no-dev

# تشغيل أوامر تحضيرية (اختياري لكن يفضل لمنع رسائل التحذير)
RUN php artisan storage:link
RUN php artisan config:cache
RUN php artisan route:cache

# توجيه Apache لاستخدام مجلد public كجذر للموقع
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# نقطة الدخول النهائية (تستخدم لضمان أن الصلاحيات صحيحة عند كل تشغيل)
ENTRYPOINT ["/bin/bash", "-c", "chown -R www-data:www-data /var/www/html && exec apache2-foreground"]