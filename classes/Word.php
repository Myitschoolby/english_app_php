<?php

class Word {

    private $data = [
        'word' => '',
        'translate' => '',
        'category' => ''
    ];

    function __construct($word, $translate, $category = '') {
        $this->set($word, $translate, $category);
    }

    private function set($word, $translate, $category = '') {
        if (!empty($word)) $this->data['word'] = $word;
        if (!empty($translate)) $this->data['translate'] = $translate;

        if ($category !== '') $this->data['category'] = $category;
    }

    function get() {
        return $this->data;
    }
    
}