# 1. طبقة الأساس: استخدام صورة PHP رسمية مع نسخة 8.4`
FROM php:8.4-fpm

# 2. تثبيت الإضافات الضرورية لـ Laravel (مثل pdo_mysql)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl
    
# تثبيت ملحقات PHP المطلوبة لقواعد البيانات
RUN docker-php-ext-install pdo_mysql gd

# 3. تثبيت Composer داخل الحاوية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. تحديد مجلد العمل داخل الحاوية
WORKDIR /var/www

# 5. نسخ ملفات مشروعك من جهازك إلى داخل الحاوية
COPY . /var/www

# 6. إعطاء الصلاحيات المناسبة لمجلدات Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/cache

# 7. الأمر الذي سيتم تنفيذه عند تشغيل الحاوية
CMD ["php-fpm"]