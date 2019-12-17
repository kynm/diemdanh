<?php

// return [
//     'class' => 'yii\db\Connection',
//     'dsn' => 'oci:dbname=//10.51.188.23:1521/OMCQNM;charset=UTF8',
//     'username' => 'OMC_NEW',
// 	'password' => 'omcdata#1',
//     'charset' => 'utf8',
// ];

return array(
    'class'=>'\sfedosimov\oci8pdo\Oci8PDO_Connection',
    'dsn' => 'oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.51.188.23)
                                       (PORT=1521))(CONNECT_DATA=(SERVICE_NAME=OMCQNM)));charset=UTF8;',
    'username' => 'OMC_NEW',
    'password' => 'omcdata#1',
);