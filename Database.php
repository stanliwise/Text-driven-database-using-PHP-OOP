<?php
    include_once('src/user.php');
    include_once('src/validatorUtil.php');

    class Database{
        protected $filename;
        public $error;

        public function __construct($filename){
            if(!file_exists($filename)){
                throw new Exception('file does not exist');
            }

            $this->filename = $filename;
        }

        public function addUser($username, $password, $email){
            if($this->userExist($username)){
                $this->error = 'username already exist';
                return false; 
            }

            if($this->emailExist($email)){
                $this->error = 'Email already exist';
                return false;
            }

            if(strlen($username) < 2){
                $this->error = 'username is too short';
                return false;
            }

            if(strlen($password) < 2){
                $this->error = "password is too short";
                return false;
            }

            if(strlen($email) < 5){
                $this->error = 'email is too short';
                return false;
            }

            if(!Validator::email($email)){
                $this->error = ' insert a valid email address';
                return false;
            }

            $password = md5($password);
            $id = $this->getLastId() + 1;
            $content = file_get_contents($this->filename);
            $data = $content . "id: {$id} username: {$username} password: {$password} email: {$email}\r\n";
            if(file_put_contents($this->filename, $data)){
                return true;
            }

            return false;
        }

        public function removeUser($username){
            if($this->userExist($username)){
                $user = $this->getUserByUsername($username);
                $data = "id: {$user->getId()} username: {$user->getUsername()} password: {$user->getPassword()} email: {$user->getEmail()}\r\n";
                $handle = file_get_contents($this->filename);
                $content = str_replace($data, '', $handle);
                file_put_contents($this->filename, $content);
                return true;
            }

            throw new Exception('username does not exist');
        }

        public function updatePassword($userId, $new_password){
            if(strlen($new_password) < 2){
                $this->error = 'password is too short';
                return false;
            }

            $new_password = md5($new_password);
            $user = $this->getUserById($userId);
            if($user){
                $data = "id: {$user->getId()} username: {$user->getUserName()} password: {$user->getPassword()} email: {$user->getEmail()}";
                $new_data ="id: {$user->getId()} username: {$user->getUserName()} password: {$new_password} email: {$user->getEmail()}"; 
                $handle = file_get_contents($this->filename);
                $content = str_replace($data, $new_data, $handle);
                if(file_put_contents($this->filename, $content))
                    return true;
                else
                    return false;
            }else{
                throw new Exception("No user with $userId exist");
            }
        }

        public function getUserById($userId = 0){
            $userId = (int) $userId;
            $data = false;
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', $content);
            foreach($lines as $line){
                $line = chop($line);
                if(preg_match("/\Aid: ($userId) username: (\w+) password: (\w+) email: (\w+@\w+\.\w+)/", $line, $matches)){
                    $data = $matches;
                    break;
                }
                
            }

            if($data){
                $user = new User($this, $matches[1], $matches[2], $matches[3], $matches[4]);
                return $user;
            }

            return false;
        }

        public function getUserByEmail($email = ''){
            $userId = $username;
            $data = false;
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', $content);
            foreach($lines as $line){
                $line = chop($line);
                if(preg_match("/\Aid: (\d) username: (\w+) password: (\w+) email: ($email)/", $line, $matches)){
                    $data = $matches;
                    break;
                }
                
            }

            if($data){
                $user = new User($this, $matches[1], $matches[2], $matches[3], $matches[4]);
                return $user;
            }

            return false;
        }

        public function getUserByUsername($username = ''){
            $data = false;
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', $content);
            foreach($lines as $line){
                $line = chop($line);
                if(preg_match("/\Aid: (\d) username: ($username) password: (\w+) email: (\w+@\w+\.\w+)/", $line, $matches)){
                    $data = $matches;
                    break;
                }
                
            }

            if($data){
                $user = new User($this, $matches[1], $matches[2], $matches[3], $matches[4]);
                return $user;
            }

            return false;
        }

        public function login($username, $password){
            if($this->userExist($username)){
                $user = $this->getUserByUsername($username);
                if($user->getPassword() == md5($password)){
                    return $user;
                }
            }

            return false;
        }

        /**
         * @var username check if a user exist by using it username
         * 
         * @return bool return true if it exist else return false
         */
        protected function userExist($username){
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', $content);
            foreach($lines as $line){
                $line = chop($line);
                if(preg_match("/username: (\b$username\b)/", $line, $matches)){
                    return true;
                }
                
            }

            return false;
        }

        protected function emailExist($email){
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', $content);
            foreach($lines as $line){
                $line = chop($line);
                if(preg_match("/email: ($email)/", $line, $matches)){
                    return true;
                    break;
                }

                return false;
            }

            return false;
        }

        protected function getLastId(){
            $content = file_get_contents($this->filename);
            $lines = preg_split('/\r\n/', trim($content));
            $last_entry = count($lines);
                $line = chop($lines[$last_entry - 1]);
                if(preg_match('/id: (\d)/', $line, $match)){
                    return (int)$match[1];
                }

            return 0;
        }
    }