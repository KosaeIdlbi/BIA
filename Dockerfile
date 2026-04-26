FROM php:8.2-cli

# تثبيت المتطلبات الأساسية فقط (تقليل فشل build)
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# نسخ المشروع
COPY . .

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader

# إصلاح الصلاحيات (مهم جدًا)
RUN chmod -R 777 storage bootstrap/cache || true

# إجبار Laravel على وجود key (تجنب crash)
RUN php artisan key:generate || true

# تنظيف الكاش
RUN php artisan config:clear || true
RUN php artisan route:clear || true

# فتح البورت الذي يتوقعه Render
EXPOSE 10000

# 🔥 أهم سطر: تشغيل PHP server بشكل مباشر
CMD php -S 0.0.0.0:$PORT -t public