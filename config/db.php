<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=database;dbname=mizar',
    'username' => 'mizar',
    'password' => 'secret',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
