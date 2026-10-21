FROM wordpress:latest

RUN apt-get update && apt-get install -y --no-install-recommends \
    less \
    vim \
    && rm -rf /var/lib/apt/lists/*


RUN { \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=64M'; \
    echo 'memory_limit=256M'; \
} > /usr/local/etc/php/conf.d/custom.ini

EXPOSE 80