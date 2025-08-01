FROM php:8.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update \
  && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    supervisor \
    nodejs \
    npm \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
  && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add Supervisor config
COPY ./docker/supervisor/supervisor.conf /etc/supervisor/conf.d/supervisord.conf

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user

ENTRYPOINT [ "php-fpm" ]

# CMD ["bash", "-c", "supervisord -n -c /etc/supervisor/conf.d/supervisord.conf"]


