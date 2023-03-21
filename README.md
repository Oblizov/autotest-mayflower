# Autotest Mayflower
Данные тесты проверяют следующие rest-api методы:
### Создание пользователя
```
curl --request POST \
--url http://3.145.97.83:3333/user/create \
--header 'Content-Type: application/json' \
--data '{
"username": "{username}",
"email": "{email}",
"password": "{password}"
}'
```
### Получение пользователей
```
curl --request GET \
  --url http://3.145.97.83:3333/user/get
```
### Запуск
Запуск тестов производится командой:
```bash
php vendor/bin/phpunit UserApiTest.php
```
### При разарботке использовалось:
* **PHP 8.2** 
* **phpunit 10.0**
* **guzzle 7.5** - для отправки запросов
* **faker 1.21** - генерации данных для пользователей
### Были автоматизированны следующие кейсы:
* `Создание пользователя и его получение по id UserApiTest.testPostAndGetUserById`
* `Создание пользователя и его получение по username UserApiTest.testPostAndGetUserByUsername`
* `Создание пользователя и его получение по email UserApiTest.testPostAndGetUserByEmail`
* `Создание пользователя и его получение из списка пользователей UserApiTest.testPostAndCheckLastUser`

