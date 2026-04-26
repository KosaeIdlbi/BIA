FROM php:8.2-apache

# تثبيت الحزم الضرورية (بما في ذلك مكتبة postgres)
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
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl gd bcmath

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل Apache Rewrite Module
RUN a2enmod rewrite

# إظهار الأخطاء
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . /var/www/html



# حل مشكلة الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# تثبيت مكتبات PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# إنشاء رابط التخزين
RUN php artisan storage:link

# توجيه Apache لاستخدام مجلد public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# --- NEW: تغيير نقطة الدخول لاستخدام ملف السكربت الخاص بنا ---
# --- NEW: نسخ ملف entrypoint.sh وإعطاءه صلاحيات التنفيذ ---
# COPY entrypoint.sh /usr/local/bin/entrypoint.sh
# RUN chmod +x /usr/local/bin/entrypoint.sh
# ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]


# الأمر الافتراضي (سيرفر Apache) سيتم تمريره للسكربت عند التنفيذ
CMD ["apache2-foreground"]