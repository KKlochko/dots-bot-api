FROM laradock/workspace:latest-8.2

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /code
COPY . /code

RUN composer install --prefer-dist

COPY ./entrypoint.sh /
ENTRYPOINT ["sh", "/entrypoint.sh"]

