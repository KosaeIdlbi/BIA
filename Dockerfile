FROM php:8.2-apache

# تثبيت الحزم الضرورية (Postgres, Node.js, وغيرها)
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
    # تثبيت Node.js لعمل npm run build
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl gd bcmath \
    # تنظيف ذاكرة التخزين المؤقت لتقليل حجم الصورة
    && rm -rf /var/lib/apt/lists/*

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل Apache Rewrite Module
RUN a2enmod rewrite

# إظهار الأخطاء (للتسهيل في الـ Debugging)
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . /var/www/html

# تثبيت مكتبات PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# بناء التنسيقات (Assets) باستخدام Vite
RUN npm install && npm run build

# إنشاء رابط التخزين
RUN php artisan storage:link

# توجيه Apache لاستخدام مجلد public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# --- حل نهائي لمشكلة الصلاحيات ---
# إعادة تعيين الملكية لـ www-data
RUN chown -R www-data:www-data /var/www/html

# تعديل الصلاحيات (المجلدات 775، الملفات 664)
RUN find /var/www/html -type d -exec chmod 775 {} \;
RUN find /var/www/html -type f -exec chmod 664 {} \;

# صلاحيات خاصة بمجلدات الكتابة
RUN chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# --- نسخ ملف نقطة الدخول ---
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# نقطة الدخول
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# الأمر الافتراضي لتشغيل Apache
CMD ["apache2-foreground"]