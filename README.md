# Instagram на Yii + Vue.js 
## от студентов GeekBrains
#### групповой проект в рамках курса [Методологии разработки Agile/Scrum](https://geekbrains.ru/lessons/60303)

#### Цель:
создать минимально жизнеспособный продукт – прототип социальной сети Instagram 

#### Имплементация:
- Базовую архитектуру приложения задает Yii2 basic шаблон,
- Контроллеры сущностей обращаются к данным, хранимым в DB,
- Обработанные данные рендерит страница отображения, задействуя компоненты Vue.js.

#### Сущности проекта:
User, Media


#### Для разработки:
В папке config создать два файла: 

* params-local.php
```
return ['components' => [
    'request' => [
        'cookieValidationKey' => '',
        ],
    ]
]
```

* db-local.php
```
return [
    'dsn' => 'mysql:host=db;dbname=geekgram',
    'username' => 'root',
    'password' => 'password',
    
];
```

#### Для запуска проекта в продакшн
Предполагаем использовать облачную платформу [heroku](https://www.heroku.com/)
