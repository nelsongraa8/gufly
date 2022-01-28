FROM php:8.0.9-fpm
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

### Annadido nuevo para conectarme al proxy
# RUN export http_proxy=http://152.206.177.141:4200/
# RUN export ftp_proxy=http://152.206.177.141:4200/

# RUN $ sudo apt-get -o Acquire::http::Proxy='http://152.206.177.141:4200' update

RUN apt-get -o Acquire::http::Proxy='http://152.206.177.141:4200' update 

RUN apt-get -o Acquire::http::Proxy='http://152.206.177.141:4200' install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -x 152.206.177.141:4200 https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /var/www/librarify
RUN ls