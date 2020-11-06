<?php

class Word {

    public $data = [
        'word' => '',
        'translate' => ''
    ];

    function __construct($word, $translate) {
        $this->set($word, $translate);
    }

    function edit($word = '', $translate = '') {
        $this->set($word, $translate);
    }

    function set($word, $translate) {
        if (!empty($word)) $this->data['word'] = $word;
        if (!empty($translate)) $this->data['translate'] = $translate;
    }

    function get() {
        return $this->data;
    }
    
}