<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/factories/UserFactory.php';
require_once __DIR__ . '/seeders/UserSeeder.php';

use database\seeders\UserSeeder;


$pdo = require __DIR__ . '/../config/config.php';

$seeder = new UserSeeder($pdo);
$seeder->seed();