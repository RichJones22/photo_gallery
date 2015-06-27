<?php 
require_once(LIB_PATH.DS."database.php");

class DatabaseObject {
    // common database methods

    public static function count_all() {
        global $database;

        $sql = "select count(*) from ". static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_all() {
            $result_set = static::find_by_sql("select * from ".static::$table_name);
            return $result_set;
    }

    public static function find_by_id($id=0) {
            // array_shift pulls the first element out of the array.
            // we could also use $result_array[0] as well...
            global $database;
            $result_array = static::find_by_sql("select * from ".static::$table_name. " where id=". $database->escape_value($id). " limit 1");
            return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql="") {
    /*
    -- returns an array of User objects, one for each row returned from fetch_array().
    -- all objects in the array have the attributes set. 
    */
            global $database;
            $result_set = $database->query($sql);
            $object_array = array();
            while ($row = $database->fetch_array($result_set)) {
                    $object_array[] = static::instantiate($row);
            }
            return $object_array;
    }

    public static function get_current_page($page) {

        $sql  = "select * from ". static::$table_name;
        $sql .= " limit ". $page->per_page;
        $sql .= " offset ". $page->offset();

        $result_set = static::find_by_sql($sql);
        return $result_set;
    }

    private static function instantiate($record) {
            // Could check that the $record exists and is an array
            // Simple, long-form approach

            // can also user get_called_class in place of static below.

            $object = new static;

    //		$object->id         = $record['id'];
    //		$object->username   = $record['username'];
    //		$object->password   = $record['password'];
    //		$object->first_name = $record['first_name'];
    //		$object->last_name  = $record['last_name'];

            // more dynamic, short-form approach:
            foreach($record as $attribute=>$value) {
                    if ($object->has_attribute($attribute)) {
                            $object->$attribute = $value;
                    }
            }
            return $object;
    }

    private function has_attribute($attribute) {
            // get_object_vars returns an associative array with all attributes
            // (incl. private ones!) as the keys and their current values as the 
            // value
            $object_vars = $this->attributes();

            // We don't care about the value, we just want to know if the key exists
            // Will return true or false.
            return array_key_exists($attribute, $object_vars);
    }

    protected function attributes() {
            // return an array of attribute keys and there values
            global $database;

            //$row_result = $database->query("select * from ". static::$table_name. " where id=1 limit 1");

            $row_result = $database->query("select * from ". static::$table_name. " limit 1");

            $finfo = mysqli_fetch_fields($row_result);

            //echo "attributes are: ". print_r($finfo);

            $attribute = array();
            foreach ($finfo as $val) {
                    $name = $val->name;
                    if(property_exists($this, $name)) {
                            $attribute["{$name}"] = $this->$name; //"'$"."{$name}'";
                    }
            }   
            mysqli_free_result($row_result);

            return $attribute;

    }

    protected function attributes01() {
        // return an array of attribute keys and there values
        $attribute = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attribute[$field] = $this->$field;
            }
        }

        print_r($attribute);

        return $attribute;

    }

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // note: does not alter the actual value of each attribute

        foreach($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }

        //print_r($clean_attributes);

        return $clean_attributes;	
    }

    private function remove_id_from_attributes($attributes) {
        $tmp_attributes = array();

        //print_r($attributes);

        foreach($attributes as $key => $field) {
            if (!empty($field) && $key != 'id') {
                $tmp_attributes[$key] = $field;
            }
        }

        //print_r($tmp_attributes);

        return $tmp_attributes;
    }

    public function create() {
        global $database;

        //$attributes = $this->sanitized_attributes();

        //print_r($attributes);	

        $attributes = static::remove_id_from_attributes($this->sanitized_attributes());

        //print_r($attributes);

        $sql  = "insert into " .static::$table_name. "(";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") values ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        //echo "the sql statement is: {$sql}<br/ >";

        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $attributes = static::remove_id_from_attributes($this->sanitized_attributes());

        //print_r($attributes);

        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        //print_r($attribute_pairs);

        $sql  = "update " .static::$table_name. " set ";
        $sql .= join(", ", array_values($attribute_pairs));
        $sql .= " where id="   . $database->escape_value($this->id);

        echo "sql is: " . $sql . "<br/>";

        $database->query($sql);

        //echo "rows affected is: " .$database->affected_rows() ."<br />";

        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete() {
        global $database;

        $sql  = "delete from " .static::$table_name;
        $sql .= " where id="   . $database->escape_value($this->id);

        $database->query($sql);

        //echo "rows affected is: " .$database->affected_rows() ."<br />";

        return ($database->affected_rows() == 1) ? true : false;
    }

    public function destory() {
        // 1. delete all comments for photograph_id
        // 2. delete the photograph itself.
        // 3. remove the file.

        if(Comment::delete_comments($this->id)) {
            if($this->delete()) {
                $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
                return unlink($target_path) ? true : false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


?>