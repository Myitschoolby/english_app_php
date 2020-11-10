<?php

require_once 'Word.php';
require_once 'Translate.php';

class Words {

    private static $data = [];

    static function add($word, $translate = '') {
        if (empty($word)) return;

        if (empty($translate)) $translate = Translate::get($word);

        if (!empty($translate)) {
            $word = new Word($word, $translate);

            array_push(self::$data, $word->get());

            self::update_data();
        }
    }

    static function edit($index, $name, $translate) {
        $index = (int)$index;

        if (!isset(self::$data[$index])) return false;

        self::$data[$index]['word'] = $name;
        self::$data[$index]['translate'] = $translate;
        
        self::update_data();

        return true;
    }

    static function delete($index) {
        $index = (int)$index;

        if (!isset(self::$data[$index])) return false;

        unset(self::$data[$index]);
        self::update_data();

        return true;
    }

    private static function update_data() {
        $path_dir = $_SERVER['DOCUMENT_ROOT'] . '/data';
        $path_data = $path_dir . '/words.json';

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
        $path_data = $path_dir . '/words.json';

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