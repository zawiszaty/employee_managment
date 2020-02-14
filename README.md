[![CircleCI](https://circleci.com/gh/zawiszaty/employee_managment.svg?style=svg)](https://circleci.com/gh/zawiszaty/employee_managment)
[![Coverage Status](https://coveralls.io/repos/github/zawiszaty/employee_managment/badge.svg?branch=master)](https://coveralls.io/github/zawiszaty/employee_managment?branch=master)
# employee_managment
## How to run
You must have installed docker and docker-compose locally 
### Linux or mac
```bash
make env
```
```bash
make start
```
Wait few minutes, you can monitor installation status by `docker-compose logs -f` or run script `./.docker/wait_for_nginx.sh`
### Windows
Copy .env.dist to .env
```bash
docker-compose up -d
```
Wait few minutes, you can monitor installation status by `docker-compose logs -f`