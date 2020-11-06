<?php

class Categories {

    static $data = ['Nattures', 'Auto', 'Business', 'Education'];

    static function add($name) {
        if (!empty($name)) array_push(self::$data, $name);
    }

    static function edit($name) {
        
    }

    static function delete($name) {

    }

    static function get() {
        return self::$data;
    }

}