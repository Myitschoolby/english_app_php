<?php

class Translate {

    static function get($word) {
        $translate = '';

        $url = 'https://tmp.myitschool.org/API/translate/?source=ru&target=en&word=' . $word;
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true
        ]);

        $data = curl_exec($ch);
        
        if (!empty($data)) $data = json_decode($data, true);

        if (json_last_error() === 0 && isset($data['translate'])) $translate = $data['translate'];

        return $translate;
    }
    
}