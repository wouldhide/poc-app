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
RUN pear config-set http_proxy ${HTTP_PROXY} \
    && printf "\n" | pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

USER root

# set proxy for curl
RUN export http_proxy="${HTTP_PROXY}"
RUN export https_proxy="${HTTP_PROXY}"

# Install SQLSRV driver
RUN set -eux; \
    ###########################################################################
    # Ref from https://github.com/Microsoft/msphpsql/wiki/Dockerfile-for-adding-pdo_sqlsrv-and-sqlsrv-to-official-php-image
    ###########################################################################
    # Add Microsoft repo for Microsoft ODBC Driver for Linux
    apt-get install -y apt-transport-https gnupg \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update -yqq \
    # Install Dependencies
    && ACCEPT_EULA=Y apt-get install -y unixodbc unixodbc-dev libgss3 odbcinst msodbcsql17 locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    # link local aliases
    && ln -sfn /etc/locale.alias /usr/share/locale/locale.alias \
    && locale-gen \
    # Install pdo_sqlsrv and sqlsrv from PECL. Replace pdo_sqlsrv-4.1.8preview with preferred version.
    && pear config-set http_proxy ${HTTP_PROXY} \
    && pecl install pdo_sqlsrv-5.6.1 sqlsrv-5.6.1 \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv \
    && php -m | grep -q 'pdo_sqlsrv' \
    && php -m | grep -q 'sqlsrv'

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
COPY . /var/www
COPY local.ini /usr/local/etc/php/conf.d/

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

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

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]