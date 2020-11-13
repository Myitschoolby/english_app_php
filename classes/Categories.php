<?php

require_once 'Words.php';

class Categories {

    static $data = [];

    private static function recursive_array_search($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && self::recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }

    static function add($name) {
        if (!empty($name)) array_push(self::$data, $name);

        self::update_data();
    }

    static function edit($index, $name) {
        $index = (int)$index;

        if (empty($name) || !isset(self::$data[$index])) return false;

        self::$data[$index] = $name;
        
        self::update_data();

        return true;
    }

    static function delete($index) {
        $search_result = self::recursive_array_search($index, Words::get());

        if ($search_result !== false) return false;

        $index = (int)$index;

        if (!isset(self::$data[$index])) return false;

        unset(self::$data[$index]);
        self::update_data();

        return true;
    }

    private static function update_data() {
        $path_dir = $_SERVER['DOCUMENT_ROOT'] . '/data';
        $path_data = $path_dir . '/categories.json';

        if (count(self::$data) > 0) {
            $data_json = json_encode(self::$data);

            if (json_last_error() === 0) file_put_contents($path_data, $data_json);
        } else {
            $file = fopen($path_data, "w+");
            fclose($file);
        }
    }

    static function get_data() {
        $path_dir = $_SERVER['DOCUMENT_ROOT'] . '/data';
        $path_data = $path_dir . '/categories.json';

        if (!is_dir($path_dir)) mkdir($path_dir);

        if (!file_exists($path_data)) {
            $file = fopen($path_data, "w+");
            fclose($file);
        }

        $file_data = file_get_contents($path_data);

        $data = json_decode($file_data, true);

        if (json_last_error() === 0) self::$data = $data;
    }

    static function get($index = '') {
        if ($index !== '') $index = (int)$index;

        return (isset(self::$data[$index])) ? self::$data[$index] : self::$data;
    }

}