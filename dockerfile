FROM php:8.2-apache

#install required system packages and dependencies
RUN apt-get update && apt-get install -y libpq-dev \
    && rm -rf /var/lib/apt/lists/*

#set the working directory coontents into the container at /var/
WORKDIR /var/www/html

#copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/

#adding Postgres support:
RUN docker-php-ext-install pdo_pgsql

# copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# enable Apache modules
RUN a2enmod rewrite

# expose port 80 to allow incombing connections to the container
EXPOSE 80
