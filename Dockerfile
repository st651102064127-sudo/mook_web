FROM php:8.2-apache

# ติดตั้ง Extension ที่จำเป็นสำหรับเชื่อมต่อ MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# เปิด mod_rewrite ของ Apache (เผื่อใช้ .htaccess)
RUN a2enmod rewrite