<?php
    class Database{
        const EXTENSION = '.txt';

        protected $name;
        protected $folder_path;
        protected $created;
        protected $updated;

        public function __construct($folder_path, $auth = []) {
            $this->folder_path = $folder_path . '/';

            //path must be valid
            if(! is_dir($this->folder_path))
                throw new Exception('Database' . $folder_path . 'does not exist');
        }

        public function path(){
            return $this->full_path;
        }

        public function new_table($name, $field = [], $unique_key){
            if(count($field) < 1)
                throw new Exception("can't create Table with empty field");

            if(file_exists($this->full_path($name)))
                throw new Exception('table ' . $name . ' already exist');

            //add default id field
            $field['id'] = 'id';

            //table data
            $table = [];
            $table['meta_data'] = [];
            $table['meta_data']['name'] = $name;
            $table['meta_data']['columns'] = array_values($field);
            $table['meta_data']['created_at'] = Utility::time_now();
            $table['meta_data']['updated_at'] = Utility::time_now();
            $table['meta_data']['unique'] = '';
            if($unique_key && in_array($unique_key, $table['meta_data']['columns']))
                $table['meta_data']['unique'] = $unique_key;

            $table['data']  = [];

            //serialize
            $data = serialize($table);

            //create the text file
            $file = fopen($this->full_path($name), 'w');
            fwrite($file, $data);
            fclose($file);

            return new Table($this->full_path($name));
        }

        public function delete_table($name){
            $this->ensure_file_exist($name);

            unlink($this->full_path($name));
            return true;
        }

        public function rename_table($new_name){
            $this->ensure_file_exist($new_name);

            return false;
        }

        public function get($name){
            $this->ensure_file_exist($name);

            return new Table($this->full_path($name));
        }

        protected function ensure_file_exist($name){
            if(file_exists($this->full_path($name)))
                return true;
            else throw new Exception($this->full_path($name) . ' does not exist');
        }

        protected function full_path($name){
            return $this->folder_path . $name . self::EXTENSION;
        }
    }