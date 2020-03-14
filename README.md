# gb_insta_clone

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