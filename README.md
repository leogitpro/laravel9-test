# Laravel test

## Running

- Install

```shell
git clone https://github.com/leogitpro/laravel9-test.git
cd laravel9-test
composer install
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


- Start & Stop

```shell
export APP_PORT=8000
export APP_SERVICE=test.bentuzi.com
sail up -d
sail stop
```
<hr>
<br>

