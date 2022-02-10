test:
	vendor/bin/phpunit

step-by-step:
	vendor/bin/phpunit --order-by=defects --stop-on-failure

fresh:
	php artisan optimize:clear
	php artisan migrate:fresh
	php artisan db:seed
