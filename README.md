//Создание таска
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"title": "test title", "description": "test description", "status" : "View"}' http://test.dev.com/task/create.php

//Создание пользователя
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"fist_name": "test fist_name", "last_name": "test last_name"}' http://test.dev.com/user/create.php

//Обновления пользователя
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"user_id" : "1", "fist_name": "test fist_name1", "last_name": "test last_name1"}' http://test.dev.com/user/update.php

//Обновления таска
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"task_id" : "1", "title": "test title111", "description": "test description111"}' http://test.dev.com/task/update.php


//Назначить таск на пользователя
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"task_id": "1", "assigned_user_id": "1"}' http://test.dev.com/task/assign_user.php

//Сменить статус 
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"task_id": "1", "status": "In Progress"}' http://test.dev.com/task/change_status.php



//Получения списка тасков
curl -v -H "Accept: application/json" -H "Content-type: application/json" "http://test.dev.com/task/list.php"

//Получения списка пользователей
curl -v -H "Accept: application/json" -H "Content-type: application/json" "http://test.dev.com/user/list.php"

//Удалить таск
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"task_id": "1"}' http://test.dev.com/task/delete.php

//Удалить пользователя
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"user_id": "2"}' http://test.dev.com/user/delete.php

