#!/bin/bash

# 1. الانتظار قليلاً للتأكد من أن خدمة قاعدة البيانات استجابت (مفيد جداً في Render)
echo "Waiting for database connection..."
# يمكننا استخدام PHP نفسه للتحقق من الاتصال بدلاً من تثبيت أدوات إضافية
until php -r "try { new PDO('pgsql:host=${DB_HOST};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); echo 'OK'; } catch (Exception \$e) { echo 'WAIT'; exit(1); }" | grep OK > /dev/null; do
    echo "Database is unavailable - sleeping"
    sleep 3
done
echo "Database connected!"

# 2. تشغيل المهاجرات (Migrate)
# --force ضروري لأننا في بيئة إنتاج (Production) ويمنع لارافيل التهجير تلقائياً
echo "Running migrations..."
php artisan migrate --force

# 3. تشغيل البذور (Seeders)
# فقط إذا أردت تشغيلها دائماً
echo "Running seeders..."
php artisan db:seed --force
php artisan db:seed
# 4. تشغيل الأمر الرئيسي للحاوية (السيرفر)
# هذا الأمر سينفذ الأمر المرسل كمدخل للحاوية
exec "$@"