FROM php:8.1-fpm-alpine as linux_dependencies

# Install modules
RUN apk upgrade --update && apk --no-cache add \
        $PHPIZE_DEPS \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        icu-dev \
        libpq \
        curl-dev \
        oniguruma-dev \
        unzip \
        postgresql-dev \
        rabbitmq-c \
        rabbitmq-c-dev \
        git \
        ffmpeg

FROM linux_dependencies AS php_installation

# Extract PHP source
# Create directory for amqp extension
# Download AMQP master branch files to extension directory
# Install amqp extension using built-in docker binary
RUN docker-php-source extract \
    && mkdir /usr/src/php/ext/amqp \
    && curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC /usr/src/php/ext/amqp --strip-components=1

RUN docker-php-ext-install \
		bcmath \
    intl \
    opcache \
    mbstring \
    amqp

FROM php_installation AS php_extentions_installation

#        amqp-1.10.2 \
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql

#RUN docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
