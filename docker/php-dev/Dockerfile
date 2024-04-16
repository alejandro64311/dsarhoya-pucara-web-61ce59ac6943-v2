FROM dsarhoya/dsy-fpm-71-mariadb:2

RUN pecl install -f xdebug-2.9.0 \
    && docker-php-ext-enable xdebug 
    
# COPY symfony.ini $PHP_INI_DIR/conf.d/dsy/dsy.ini
# COPY zdsy.conf /usr/local/etc/php-fpm.d

RUN mkdir -p /var/log/php
RUN touch /var/log/php/error.log
RUN touch /var/log/php/slow.log

# COPY dsycron /etc/cron.d/dsycron
# RUN chmod 0644 /etc/cron.d/dsycron
RUN touch /var/log/cron.log

# RUN mkdir -p /var/log/supervisor
RUN mkdir -p /var/log/supervisor/dsy

# COPY dsy.conf /etc/supervisor/conf.d/dsy.conf

# CMD /usr/bin/python /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
ADD entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT /entrypoint.sh