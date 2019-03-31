<?php
class User{
    public $id;
    protected $username;
    protected $password;
    protected $email;
    protected $database;

    public function __construct(Database $database, $id, $username, $password, $email){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->database = $database;
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    /**
     * @var new_password true|false
     * 
     * @return result true|false
     */
    public function changePassword($new_password){
        $updatePassword = $this->database->updatePassword($this->id, $new_password);
        if($updatePassword){
            $this->password = md5($new_password);
            return true;
        }

        return false;
    }
}