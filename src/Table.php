<?php
    class Table{
        protected $path;
        protected $metadata;
        protected $error;

        public function __construct($path)
        {
            if(!file_exists($path))
                throw new Exception('Table does not exist');

            $this->path = $path;
            $this->metadata = $this->get_metadata();
        }

        public function insert($data = []){
            $database = $this->get_data();
            $newdata = [];

            //use this to ensure only on entry
            if($this->metadata['unique'] != ''){
                if(!isset($data[$this->metadata['unique']]) || $data[$this->metadata['unique']] == ''){
                    $this->error = 'unique field is emtpy';
                    return false;
                }
            }

            //check for duplicate unique constraint
            foreach($database as $datumbase){
                if($datumbase[$this->metadata['unique']] == $data[$this->metadata['unique']]){
                    $this->error = 'duplicate unique column';
                    return false;
                }
            }

            //fill newdata with empty value
            foreach($this->metadata['columns'] as $metadatum){
                $newdata[$metadatum] = '';
            }

            //fill in the data
            foreach($this->metadata['columns'] as $metadatum){
                if(isset($data[$metadatum])){
                    $newdata[$metadatum] = $data[$metadatum] . ''; //coerce all input to string
                }
            }

            //add id; important as it helps to override any default id
            $newdata['id'] = count($database) + 1;

            //insert new record
            $database[] = $newdata;

            //store
            $this->save_data($database);
            return true;
        }

        public function select($column, $equal){
            $data = $this->get_data();

            //if column doesn't exist return error
            if(array_search($column, $this->metadata['columns']) == false){
                $this->error = 'column doesn\'t exist';
                return null;
            }

            $result = [];
            foreach($data as $datum){
                if($datum[$column] == $equal)
                    $result[] = $datum;
            }

            return $result;
        }

        public function selectById($id){
            $data = $this->get_data();
            $count = count($data);
            if($id > 0 && !($id > $count)){
                //search data
                if($count < $id){
                    $this->error = 'no such id';
                    return null;
                }else
                    return $data[$id - 1];
            }
        }

        /**
         * Return first match
         */
        public function row($column, $equal){
            $data = $this->get_data();

            //if column doesn't exist return error
            if(array_search($column, $this->metadata['columns']) == false){
                $this->error = 'column doesn\'t exist';
                return null;
            }

            //return first match
            foreach($data as $datum){
                if($datum[$column] == $equal)
                    return $datum;
            }

            //no match was found
            return [];
        }

        public function all($count = 20){
            if(is_integer($count))  
                return array_chunk($this->get_data(), 20, true);
            
            return $this->get_data;
        }

        public function update($equal, $data = []){
            if($this->metadata['unique'] == ''){
                $this->error = 'This table cannot be updated since it has no unique key';
                return false;
            }

            if(!is_array($data)){
                $this->error = 'invalid data';
                return false;
            }

            $database = $this->get_data();

            $record = $this->row($this->metadata['unique'], $equal);

            if($record){
                //preserve unique data
                $id = $record['id'];
                $unique = $record[$this->metadata['unique']];

                foreach($record as $key => $value){
                    if(isset($data[$key]))
                        $record[$key] = $data[$key];
                }

                //restore unique data
                $record['id'] = $id;
                $record[$this->metadata['unique']] = $unique;

                //store
                $database[$id - 1] = $record;
                $this->save_data($database);
                return true;
            }
            else{
                $this->error = 'data not found';
                return false;
            }

        }

        public function updateById($id, $data = []){
            if(!is_array($data)){
                $this->error = 'invalid data';
                return false;
            }

            $database = $this->get_data();

            $record = $this->selectById($id);

            if($record){
                //preserve unique data
                $id = $record['id'];
                $unique = $record[$this->metadata['unique']];

                foreach($record as $key => $value){
                    if(isset($data[$key]))
                        $record[$key] = $data[$key] . ''; //coerce to string
                }

                //restore unique data
                $record['id'] = $id;
                $record[$this->metadata['unique']] = $unique;

                //store
                $database[$id - 1] = $record;
                $this->save_data($database);
                return true;
            } else{
                $this->error = 'data not found';
                return false;
            }

        }

        public function delete($id = -1, $where = []){
            if($id > 0){
                $data = $this->get_data();
            }
        }

        public function count($where, $equal){
            return $this->select($where, $equal);            
        }

        protected function get_data(){
            //file get content and unserialize
            $main_data = unserialize(file_get_contents($this->path));

            //return
            return $main_data['data'];
        }

        protected function save_data($data){
            //file get content and unserialize
            $main_data = unserialize(file_get_contents($this->path));

            //insert content and serialize
            $main_data['data'] = $data;

            //file put content
            $handle = fopen($this->path, 'w');
            fwrite($handle, serialize($main_data));
            fclose($handle);
        }

        public function get_metadata(){
            //file get content and unserialize
            $main_data = unserialize(file_get_contents($this->path));

            //return
            return $main_data['meta_data'];
        }

        /**
         * return last error
         */
        public function get_error(){
            return $this->error;
        }
    }

/*
- check file extension funcitonality
*/