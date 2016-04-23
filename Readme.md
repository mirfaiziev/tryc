**restful csv handler without any frameworks**

**requirements**

    It requires only php 5.6 and nginx. But if you want to run it on your local 
    you just need to install docker compose and build images
    `docker-compose -f docker-compose.yml build`
    than change hosts file - add the following line
        127.0.0.1 bootstrap.dev # for linux
    
    or get ip of docker host machine via `docker-machine env|grep HOST` for mac and windows
    
    run `docker-compose up -d` 
    
    and open bootstrap.dev:8080 in your browser
    
**running test**

    after start docker-compose run `docker exec -it tryc_phpunit_1 phpunit .`