# استخدام PHP مع FPM
FROM php:8.3-fpm

# تثبيت الحزم المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تحديد مجلد العمل
WORKDIR /var/www

# نسخ المشروع
COPY . .

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader

# إعطاء صلاحيات
RUN chmod -R 775 storage bootstrap/cache

# توليد كاش (اختياري لكنه مفيد)
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# فتح البورت (Render يعتمد على PORT)
EXPOSE 10000

# تشغيل السيرفر
CMD php artisan serve --host=0.0.0.0 --port=$PORT