#Dockerfile for nginx
FROM nginx:1.17.1-alpine

# Copy site config
COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy site source
COPY /back-php/ /var/www/html/
