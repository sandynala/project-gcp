#FROM wordpress:latest
#FROM  wordpress:5.9-php7.4
#RUN mkdir -p /var/www/html
#VOLUME /var/www/html
#WORKDIR /var/www/html
#COPY ./code .


FROM  wordpress:5.9-php7.4
#WORKDIR /usr/src/wordpress
WORKDIR /var/www/html
#RUN set -eux; \
#	find /etc/apache2 -name '*.conf' -type f -exec sed -ri -e "s!/var/www/html!$PWD!g" -e "s!Directory /var/www/!Directory $PWD!g" '{}' +; \
#	cp -s wp-config-docker.php wp-config.php
COPY ./code/wp-config.php .

COPY ./code/wp-content/themes/ ./wp-content/themes/
COPY ./code/wp-content/plugins/ ./wp-content/plugins/
COPY ./code/wp-content/uploads/ ./wp-content/uploads/

