<?php
    require_once __DIR__ . '/bootstrap.php';
    
    //current database folder to access
    $database = DBFactory::get('stanDatabase');

    
    //$database->new_table('stanliwise', ['name', 'email', 'password'], 'email');

    $table = $database->get('User');
    var_dump($table->get_metadata());
    $table->updateById(2, ['name' => 'kolawole', 'id' => 3]);
    echo $table->get_error(), "\n";
    var_dump($table->selectById(2));