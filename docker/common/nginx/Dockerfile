FROM nginx:stable-alpine

WORKDIR /var/www

COPY ./backend /var/www/api
COPY ./frontend /var/www/public
COPY ./docker/common/nginx/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]