dev_db:
	docker run --rm -it -v dev_mysql_vol:/var/lib/mysql \
	-e MYSQL_DATABASE=threls \
	-p 3306:3306 \
	-e MYSQL_ROOT_PASSWORD=secret \
	mysql

dev:
	php artisan serve

migrate:
	php artisan migrate --seed

rollback:
	php artisan migrate:rollback

clean:
	php artisan cache:clear && \
	composer dump-autoload

test:
	php artisan test

.PHONY: dev_db dev migrate rollback clean test
