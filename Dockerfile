FROM php:7.0-apache
WORKDIR .
# RUN apt-get install --no-install-recommends -y nano \
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
