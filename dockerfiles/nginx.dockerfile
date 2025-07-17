FROM nginx:stable-alpine
WORKDIR /etc/nginx/conf.d
COPY nginx/default.conf /etc/nginx/conf.d/
RUN rm -rf /etc/nginx/conf.d/default.conf.bak
WORKDIR /var/www/html
COPY src .