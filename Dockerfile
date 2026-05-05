FROM php:8.2-apache

# Paigaldame andmebaasi ühenduse jaoks vajalikud moodulid
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Lubame failide kirjutamise õigused (vajalik piltide üleslaadimiseks jm)
RUN chown -R www-data:www-data /var/www/html