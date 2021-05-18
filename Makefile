ifdef env
	env=test
	command = php bin/console doctrine:database:drop --force --env=$(env)
else
	env=dev
    command = php bin/console doctrine:database:drop --if-exists --force --env=$(env)
endif

db:
	composer install --prefer-dist
	$(command)
	php bin/console doctrine:database:create --env=$(env)
	php bin/console doctrine:schema:update -f --env=$(env)
	php bin/console doctrine:fixtures:load -n --env=$(env)

.PHONY: tests
tests:
	php bin/phpunit --stop-on-failure

phpcs:
	vendor\bin\phpcs

phpcbf:
	vendor\bin\phpcbf