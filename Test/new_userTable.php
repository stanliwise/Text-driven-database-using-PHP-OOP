<?php 
    require_once __DIR__ . '/bootstrap.php';

   $database = DBFactory::get('StanDatabase');

   $database->create_table('User');