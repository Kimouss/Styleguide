FROM httpd:2.4-alpine
RUN apk update;

RUN mkdir -p /var/log/httpd

COPY conf/httpd.conf /usr/local/apache2/conf/httpd.conf
COPY conf/extra/vhosts /usr/local/apache2/conf/extra/vhosts
COPY conf/extra/httpd-vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf
