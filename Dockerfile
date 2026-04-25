# استخدام صورة PHP 8.2 الرسمية مع خادم Apache
FROM php:8.2-apache

# تثبيت الامتدادات الضرورية لـ Laravel (مثل pdo_mysql, zip, gd, mbstring)
#以及对 Livewire 和其他库很重要的 curl
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

# تثبيت Composer (مدير حزم PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل Apache Module لإعادة الكتابة (Rewrite) - ضروري لـ Livewire
RUN a2enmod rewrite

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الحاوية
COPY . /var/www/html

# منح Apache ملكية المجلدات لتجنب مشاكل الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# تثبيت مكتبات PHP وتحضير المشروع
RUN composer install --optimize-autoloader --no-dev

# تشغيل الأوامر التحضيرية (تحديث الكاش، إنشاء رابط التخزين)
RUN php artisan storage:link
RUN php artisan config:cache
RUN php artisan route:cache

# تعيين ملف إعدادات Apache ليشير إلى مجلد public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf