## WordPress

### Installation
- Clone the repo: `git clone ...`
- Run docker: `docker-compose up -d`
- WordPress site: http://localhost:8000
- PhpMyAdmin: http://localhost:8080

#### Install WP-CLI Inside the WordPress Container
- Go to WP container
```
docker exec -it wordpress_app bash
```

- Install WP-CLI:
```
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp
```

- Now you can use WP-CLI commands, for example:
```
wp core version
wp plugin list
```

### Troubleshooting
- Remove the existing containers and restart everything:
```
docker-compose down -v  # Stop and remove containers + volumes
docker volume prune -f  # (optional) Remove Orphaned Volumes
docker-compose up -d    # Start fresh
```

- Setup wp-config.php database setting:
```
docker exec -it wordpress_app bash
apt update && apt install nano -y
nano /var/www/html/wp-config.php
```
edit the DB settings, save, and restart the container:
```
docker-compose restart wordpress
#or
docker-compose restart
```

- Or Copy the File to Your Local Machine, Edit It, and Copy It Back:
```
docker cp wordpress_app:/var/www/html/wp-config.php ./wp-config.php
nano wp-config.php  # Edit the file locally
docker cp wp-config.php wordpress_app:/var/www/html/wp-config.php
```

- Check DB log & App log:
```
docker logs wordpress_app
```

- Change permissions inside docker container:
```
docker exec -it wordpress_app bash
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
exit

docker-compose restart wordpress
```
