<?php

require_once 'Categories.php';
require_once 'Words.php';

class English {

    static function requests() {
        if (isset($_POST['word_add'])) {
            Words::add($_POST['word_name'], $_POST['word_translate']);
        }
    }

    static function get_categories() {
        $categories_data = Categories::get();

        $html = '';

        foreach ($categories_data as $index => $category) {
            $html .= '<li><a href="#">' . $category . '</a></li>';
        }

        return !empty($html) ? '<ul>' . $html . '</ul>' : '';
    }

    static function get_words() {
        $words_data = Words::get();

        $html = '';

        foreach ($words_data as $index => $word) {
            $html .= '<li class="word">
                <div class="word_name">' . $word['word'] . '</div>
                <div class="word_translate">' . $word['translate'] . '</div>
            </li>';
        }

        return !empty($html) ? '<ul>' . $html . '</ul>' : '';
    }

    static function view() {
        self::requests();

        echo '
        <div class="app">
        
            <div class="app_header">
                <form method="POST">

                    <div class="app_categories_form">
                        <input type="text" name="category_name" placeholder="Category name" />
                        <button name="category_add">Add</button>
                    </div>

                    <div class="app_words_form">
                        <input type="text" name="word_name" placeholder="Word" />
                        <input type="text" name="word_translate" placeholder="Translate" />
                        <button name="word_add">Translate & Add</button>
                    </div>

                </form>
            </div>

            <div class="app_main">

                <div class="app_categories">
                ' . self::get_categories() . '
                </div>

                <div class="app_words">
                ' . self::get_words() . '
                </div>

            </div>

        </div>
        ';
    }

}
