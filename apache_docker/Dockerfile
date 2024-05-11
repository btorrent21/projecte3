# Utilizamos una imagen base con soporte para Apache y PHP
FROM php:7.4-apache

# Actualizamos la lista de paquetes e instalamos herramientas necesarias
RUN apt-get update 
RUN apt-get install openssl -y
RUN docker-php-ext-install mysqli
#RUN apt-get install php8.1 -y
#RUN apt-get install php-mysql -y
#RUN apt-get install php-mysqli -y

# Creamos el directorio para almacenar los archivos SSL
RUN mkdir -p /etc/apache2/ssl

# Generamos el certificado y la clave
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt -subj "/C=ES/ST=Barcelona/L=Barcelona/O=BTPSEE/OU=Proyecto2/CN=dombtpsee.cat"

# Habilitamos los módulos de Apache necesarios
RUN a2enmod ssl
RUN a2enmod headers

# Copiamos la configuración del sitio SSL
COPY apache_ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN a2ensite default-ssl

# Copiamos la configuración del sitio HTTP
COPY apache_http.conf /etc/apache2/sites-available/000-default.conf
