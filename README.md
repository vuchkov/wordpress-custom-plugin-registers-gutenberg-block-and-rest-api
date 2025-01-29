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
