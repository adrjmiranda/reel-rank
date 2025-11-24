FROM php:8.4-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Copia arquivos para o container
COPY . /var/www/html/

# Define o diretório público correto
RUN rm -rf /var/www/html/html
RUN mv /var/www/html/public_html /var/www/html/html

# Configura o Apache para usar /html como DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/html|g' /etc/apache2/sites-available/000-default.conf

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependências
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

EXPOSE 80
