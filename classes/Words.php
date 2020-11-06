<?php

require_once 'Word.php';

class Words {

    static $data = [
        [
            'word' => 'стол',
            'translate' => 'table'
        ],
        [
            'word' => 'дверь',
            'translate' => 'door'
        ],
        [
            'word' => 'облако',
            'translate' => 'cloud'
        ]
    ];

    static function add($word, $translate = '') {
        if (empty($word)) return;

        if (!empty($translate)) {
            $word = new Word($word, $translate);

            array_push(self::$data, $word->get());
        }
    }

    static function delete() {

    }

    static function get() {
        return self::$data;
    }

}