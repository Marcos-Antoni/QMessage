# Después (usando Node.js 20 o más reciente)
FROM node:20-alpine AS build

# El resto de tu Dockerfile
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Si tienes una fase PHP (Laravel)
FROM php:8.3-fpm-alpine AS composer_dependencies
WORKDIR /app
COPY --from=composer_dependencies /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev

# Final (ejemplo para un servidor web, ajusta según tu configuración)
FROM nginx:alpine
COPY --from=build /app/public/build /var/www/html/build
COPY --from=composer_dependencies /app /var/www/html
COPY .env /var/www/html/.env 
COPY nginx.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html