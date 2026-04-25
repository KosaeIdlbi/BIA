# استخدام صورة Nginx التي تحتوي على PHP 8.2 مدمجاً (من Laravel Forge)
FROM registry.fly.io/laravelfly/php:8.2

# تعيين مجلد العمل داخل الحاوية
WORKDIR /var/www/html

# نسخ ملفات المشروع (سنستخدم .dockerignore لنسخ الأهم فقط)
COPY . /var/www/html

# تثبيت الاعتماديات
RUN composer install --optimize-autoloader --no-dev

# تشغيل الأوامر الخاصة بتحضير المشروع
RUN php artisan storage:link
RUN php artisan config:cache
RUN php artisan route:cache

# تصحيح الصلاحيات (للقراءة والكتابة)
RUN chown -R nobody:nobody /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# تشغيل خادم الويب
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]