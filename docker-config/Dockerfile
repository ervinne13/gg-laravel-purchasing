FROM ervinne/base-php-nginx:7.2

LABEL Maintainer="Ervinne Sodusta<ervinne.sodusta@nuworks.ph>"

WORKDIR /var/www/vhost/gg-purchasing

# Enable this site
RUN rm /etc/nginx/sites-enabled/vhost
ADD ./vhost-purchasing.conf /etc/nginx/sites-available
RUN ln -s /etc/nginx/sites-available/vhost-purchasing.conf /etc/nginx/sites-enabled/vhost-purchasing

# Expose React hot reloading candidate ports
EXPOSE 80
EXPOSE 443

RUN echo > /etc/resolv.conf
RUN echo "nameserver 8.8.8.8" > /etc/resolv.conf
RUN echo "nameserver 8.8.4.4" > /etc/resolv.conf

COPY ./start.sh /
RUN chmod +x /start.sh

ENTRYPOINT ["/start.sh"]
