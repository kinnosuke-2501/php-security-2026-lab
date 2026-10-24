# 学習用PHP環境: Apache + PHP 8.2 + MySQL拡張
FROM php:8.2-apache

# MySQLに接続するための拡張を有効化
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 学習用のphp設定を読み込む
COPY php.ini /usr/local/etc/php/conf.d/lab.ini

# アップロード練習用ディレクトリに書き込み権限を付与
RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads
