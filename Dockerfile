# Use Ubuntu 20.04
FROM ubuntu:20.04

# Allow install without interaction
ARG DEBIAN_FRONTEND=noninteractive

# Update the package repository and install the required packages. Download harambo_app repository and install app.
RUN apt-get update && \
apt-get update && \
apt-get install -y apache2 mysql-server php libapache2-mod-php zip unzip php-mysqlnd net-tools curl wget git && \
git clone https://github.com/Business1sg00d/harambo_app.git /opt/harambo_app && \
mv /opt/harambo_app/harambo.zip /var/www && \
mv /opt/harambo_app/setup_docker.sh /var/www && \
service mysql start && \
service apache2 start && \
chmod +x /var/www/setup_docker.sh && \
/var/www/setup_docker.sh && \
rm /var/www/html/index.html && \
sed -i 's/"localhost";/"127.0.0.1";/g' /var/www/config.php && \
rm -rf /var/lib/apt/lists/*

# Expose the required ports
EXPOSE 80

# Start the Apache and MySQL services
CMD ["/bin/bash", "-c", "service mysql start && service apache2 start && /bin/bash"]
