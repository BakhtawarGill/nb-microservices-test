# nb-microservices-test
Microservices in symfony 7

1. Install docker
2. docker compose up -d --build
3. docker container exec [php container_id] php bin/console doctrine:migrations:migrate

Testing Environment setup
1. docker container exec [php container_id] php bin/console doctrine:database:create --env=test
2. docker container exec [php container_id] php bin/console doctrine:schema:update --env=test --force

Urls to Hit
1. POST: http://localhost:8000/users (Create User)
2. GET: http://localhost:8000/users/id (Get User)