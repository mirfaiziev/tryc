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

    get php unit image name by `docker-compose ps`
    after start docker-compose run `docker exec -it $phpunit-image phpunit .`
    
    
**Before start**

    Create Exaample csv file (f.e. copy from example.csv.default) and grant read+write access to it