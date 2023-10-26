FROM php:8.1-fpm

# Install package dependencies
RUN apt-get install debian-archive-keyring \
    && apt-get update \
    && apt-get install -y cifs-utils && apt-get install -y iputils-ping \
    && apt-get update && apt-get install -y unzip libaio1 wget

# Run php as root
COPY ./.docker/php/docker.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

# PHP extensions
RUN \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-install pdo_mysql \
    && apt-get install -y libicu-dev \ 
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \ 
    && apt-get update && apt-get install -y libldap2-dev \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap


# Add sources to container for improving performance since we are using wsl2, sources filesystem between windows and wsl2 is slow
COPY /back-php/ /var/www/html/

##################    
###  OPTIONAL  ###
##################

# Run php faster with opcache
# RUN mkdir /var/www/opcache && docker-php-ext-install opcache
# COPY ./.docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# xdebug If you want to debug with xdebug, uncomment the following lines
# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug \
#     && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#     && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#     && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# PHP composer First time install composer
# RUN curl -sS https://getcomposer.org/installer | php --  --install-dir=/usr/bin --filename=composer


# Install Oracle Instantclient 
RUN mkdir /tmp/instantclient
COPY ./.docker/oracle/instantclient-basic-linux.x64-21.1.0.0.0.zip /tmp/instantclient
COPY ./.docker/oracle/instantclient-sdk-linux.x64-21.1.0.0.0.zip /tmp/instantclient
RUN cd /tmp/instantclient && \
    unzip /tmp/instantclient/instantclient-basic-linux.x64-21.1.0.0.0.zip -d /usr/local \
    && unzip /tmp/instantclient/instantclient-sdk-linux.x64-21.1.0.0.0.zip -d /usr/local
RUN rm -rf /tmp/instantclient/*.zip

# Install Oracle extensions
ENV LD_LIBRARY_PATH=/usr/local/instantclient_21_1
RUN docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/usr/local/instantclient_21_1,21.1 \
    && docker-php-ext-install pdo_oci \
    && docker-php-ext-configure oci8 --with-oci8=instantclient,/usr/local/instantclient_21_1,21.1 \
    && docker-php-ext-install oci8 \
    && docker-php-ext-enable oci8 \
    && echo 'instantclient,/usr/local/instantclient_21_1' \
    && docker-php-ext-enable oci8


# If mount is required, uncomment the following lines and comment the last line
# RUN mkdir /var/www/data/
# WORKDIR /var/www/html/
# CMD bash -c "mount -t cifs -o username=***,password=****,domain=*** /my/dir /var/www/data/ && php-fpm -F -R --allow-to-run-as-root"

WORKDIR /var/www/html/
CMD bash -c "php-fpm -F -R --allow-to-run-as-root"