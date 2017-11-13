FROM ubuntu:16.10

# Install apache, PHP, and supplimentary programs. openssh-server, curl, and lynx-cur are for debugging the container.
RUN apt-get update && apt-get -y upgrade && apt-get -y install \
 --assume-yes apt-utils apache2 php libapache2-mod-php php-mcrypt php-mysql curl php-cli php-mbstring git unzip php-xml \
 libcurl4-openssl-dev pkg-config libssl-dev libsslcommon2-dev php-pear php-dev vim rsyslog cron libfontconfig


RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Enable apache mods.
RUN a2enmod rewrite
RUN a2enmod headers

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

RUN mkdir /app
WORKDIR /app

# Expose apache.
EXPOSE 80

# Update the default apache site with the config we created.
ADD conf.d/vhosts.conf /etc/apache2/sites-enabled/000-default.conf

# Add our crontab file
ADD conf.d/crontab /etc/cron.d/crontab
# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab
# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Add our startup script to the container. This script should be executed upon starting the container.
ADD conf.d/startup.sh /usr/bin/startup.sh
RUN chmod +x /usr/bin/startup.sh

# Execute the containers startup script which will start many processes/services
CMD ["/bin/bash", "/usr/bin/startup.sh"]