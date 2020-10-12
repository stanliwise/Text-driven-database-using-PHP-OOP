<?php
    require_once __DIR__ . '/DBFactory.php';

    $database = DBFactory::get('Tester');

    
    //$database->new_table('stanliwise', ['name', 'email', 'password'], 'email');
    $table = $database->get('stanliwise');
    $table->updateById(2, ['name' => 'kolawole', 'id' => 3]);
    echo $table->get_error(), "\n";
    var_dump($table->selectById(2));