run:
	./vendor/bin/sail up

stop:
	./vendor/bin/sail stop

test:
	./vendor/bin/sail artisan test

artisan:
	./vendor/bin/sail artisan

queue:
	./vendor/bin/sail artisan queue:work
