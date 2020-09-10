<?php 
    class Utility{
        private function __construct() {
            
        }

        public static function hash($password, $hash_type = 'md5'){
            return md5($password);
        }

        public static function jsonfy($data = []){
            return json_encode($data);
        }

        public static function time_now(){
            return date('Y-m-d H:i:s');
        }
    }