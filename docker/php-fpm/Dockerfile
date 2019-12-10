FROM php:7.3-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    libldap2-dev \
    libmcrypt-dev \
    #    git \
    wget \
    curl \
    sudo

# Install Redis
RUN printf "\n" | pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

USER root

# take down openssl default to 1024 rsa key - must have for php sqlsrv compatibility
RUN sed -i -E 's/(CipherString\s*=\s*DEFAULT@SECLEVEL=)2/\11/' /etc/ssl/openssl.cnf

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install extensions
RUN docker-php-ext-configure zip --with-libzip=/usr/include
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-install bcmath
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap

# Install composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www && echo "www:www" | chpasswd && adduser www sudo

# Copy existing application directory contents
COPY / /var/www
COPY docker/php-fpm/local.ini /usr/local/etc/php/conf.d/

# Copy existing application directory permissions
COPY --chown=www:www / /var/www

# Change current user to www
USER www

# fix vi/vim comaptibility
# RUN echo "set nocompatible" >> ~/.vimrc \
#     && echo "set nocompatible" >> ~/.exrc \ 
#     && echo "set term=builtin_ansi" >> ~/.exrc \
#     && echo "set term=builtin_ansi" >> ~/.vimrc \
#     && echo "syntax on" >> ~/.vimrc

RUN echo "set term=builtin_ansi" >> ~/.exrc \
    && echo "set term=builtin_ansi" >> ~/.vimrc \
    && echo "syntax on" >> ~/.vimrc

# set alias for php artisan
RUN echo 'alias art="php artisan"' >> ~/.bashrc

WORKDIR /var/www


RUN composer install

RUN php artisan config:cache 
RUN php artisan route:cache 


# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]