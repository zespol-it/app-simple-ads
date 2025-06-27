FROM php:8.2-fpm

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalacja Composera
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Ustawienia katalogu roboczego
WORKDIR /var/www

# Kopiowanie plików aplikacji (na razie puste)
COPY . /var/www

# Ustawienia uprawnień
RUN chown -R www-data:www-data /var/www

# Ustawienia portu
EXPOSE 9000

CMD ["php-fpm"] 