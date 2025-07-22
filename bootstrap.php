<?php
define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('HANDLERS_PATH', BASE_PATH . '/handlers');
define('DUMMIES_PATH', BASE_PATH . '/staticDatas/dummies');
chdir(BASE_PATH);
