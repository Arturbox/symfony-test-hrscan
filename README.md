cd docker

docker volume create postgresdata && docker volume create postgresdatatest

docker compose up -d --force-recreate

docker compose exec php composer install

docker compose exec php ./bin/console doctrine:migrations:migrate \
&& docker compose exec php ./bin/console doctrine:fixtures:load --group=dev


docker compose exec php ./bin/console --env=test doctrine:schema:drop --force \
&& docker compose exec php ./bin/console --env=test doctrine:schema:update --force \
&& docker compose exec php ./bin/console --env=test doctrine:fixtures:load --group=test \
&& docker compose exec php ./bin/phpunit

