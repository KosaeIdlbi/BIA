FROM php:8.3-cli

# تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# نسخ المشروع
COPY . .

# تثبيت Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# إصلاح الصلاحيات
RUN chmod -R 775 storage bootstrap/cache || true

# إنشاء APP_KEY تلقائيًا إذا غير موجود
RUN php artisan key:generate --force || true

# حذف الكاش القديم (مهم)
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# تأكد أن public هو root
WORKDIR /var/www/public

EXPOSE 10000

# 🔥 الحل النهائي: تشغيل PHP مباشرة بدون artisan serve
CMD php -S 0.0.0.0:$PORT index.php