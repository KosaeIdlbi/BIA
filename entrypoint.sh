#!/bin/bash

# --- 1. إصلاح مشكلة الصلاحيات للملفات الحية ---
# هذا الأمر ضروري لمنع خطأ "Permission denied" في ملف laravel.log
echo "Fixing storage permissions..."
if [ -f /var/www/html/storage/logs/laravel.log ]; then
    chmod 777 /var/www/html/storage/logs/laravel.log
fi
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# --- 2. الانتظار للاتصال بقاعدة البيانات ---
echo "Waiting for database connection..."
# حلقة تكرار حتى ينجح الاتصال
until php -r "try { new PDO('pgsql:host=${DB_HOST};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); echo 'OK'; } catch (Exception \$e) { echo 'WAIT'; exit(1); }" | grep OK > /dev/null; do
    echo "Database is unavailable - sleeping"
    sleep 3
done
echo "Database connected!"

# --- 3. تشغيل المهاجرات (Migrations) ---
echo "Running migrations..."
php artisan migrate --force

# --- 4. تشغيل البذور (Seeders) ---
# أضفنا || true لاستمرار العمل حتى لو حدث خطأ في الـ Seed (لتجنب مشاكل البيانات المكررة)
echo "Running seeders..."
# php artisan db:seed --force -v || true

echo "Starting server..."

# --- 5. تشغيل الأمر الرئيسي للحاوية ---
exec "$@"