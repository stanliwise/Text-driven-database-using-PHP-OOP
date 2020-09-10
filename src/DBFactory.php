<?php
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Table.php';
    require_once __DIR__ . '/Utility.php';
    require_once __DIR__  . '/Database.php';

    class DBFactory{
        //default path
        public static $repo_path = STORAGE_PATH . '/';

        private static $dbs = [];

        private function __construct() {

        }

        public static function get($name){
            if(isset(self::$dbs[$name]))
                return self::$dbs[$name];

            //check if folder exist
            if(is_dir(self::$repo_path . $name)){
                self::$dbs[$name] = new Database(self::$repo_path . $name);
                return self::$dbs[$name];
            }

            throw new Exception('invalid folder path');
        }

        public static function free($name){
            if(isset(self::$dbs[$name]))
                unset(self::$dbs[$name]);
        }
    }