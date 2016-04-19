install docker compose

build: docker-compose -f docker-compose.yml build

run unit-test: docker exec -it tryc_phpunit_1 phpunit .