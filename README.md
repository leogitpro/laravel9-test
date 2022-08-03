# Laravel test

## Running

- Install

```shell
docker pull php:8.1
docker pull composer:2.2
git clone https://github.com/leogitpro/laravel9-test.git
cd laravel9-test
cp .env.example .env
docker run --rm -it -v $PWD:/app -w /app -v ${COMPOSER_HOME:-$HOME/.composer}:/tmp composer:2.2 composer install
docker run -it --rm -v $PWD:/app -w /app php:8.1 php artisan sail:install
```
<hr>
<br>


- Add command to `.bashrc`

```shell
echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc
```
<hr>
<br>


- Start & Stop

```shell
export APP_PORT=8000
# export APP_SERVICE=test.bentuzi.com
sail up -d
sail stop
```
<hr>
<br>


- Execute artisan command or php command or bash

```shell
sail artisan list
sail artisan key:generate
sail php --version
sail shell
sail root-shell
```
<hr>
<br>

