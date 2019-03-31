<?php
    class Validator{
        public static function email($email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                return true;
            }

            return false;
        }
    }