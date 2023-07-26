#/bin/sh

/usr/sbin/service nginx start
/usr/sbin/service php8.1-fpm start

while true; do sleep 1; done