<?php

require_once 'Categories.php';
require_once 'Words.php';

class English {

    private static function requests() {
        Words::get_data();

        if (isset($_POST['word_add'])) {
            Words::add($_POST['word_name'], $_POST['word_translate']);
        }

        if (isset($_POST['word_save'])) {
            if (Words::edit($_GET['word'], $_POST['word_name'], $_POST['word_translate'])) {
                header('Location: /');
                exit;
            }
        }

        if (isset($_GET['word']) && 
            isset($_GET['action']) &&
            $_GET['action'] === 'delete'
        ) {
            if (Words::delete($_GET['word'])) {
                header('Location: /');
                exit;
            }
        }
    }

    private static function get_categories() {
        $categories_data = Categories::get();

        $html = '';

        foreach ($categories_data as $index => $category) {
            $html .= '<li><a href="#">' . $category . '</a></li>';
        }

        return !empty($html) ? '<ul>' . $html . '</ul>' : '';
    }

    private static function get_words() {
        $words_data = Words::get();

        $html = '';

        foreach ($words_data as $index => $word) {
            $html .= '<li class="word">
                <div class="word_name">' . $word['word'] . '</div>
                <div class="word_translate">' . $word['translate'] . '</div>
                <div class="word_btns">
                    <a href="/?word=' . $index . '&action=edit">Edit</a>
                    <a href="/?word=' . $index . '&action=delete">X</a>
                </div>
            </li>';
        }

        return !empty($html) ? '<ul>' . $html . '</ul>' : '';
    }

    static function view() {
        self::requests();

        if (isset($_GET['word']) && 
        isset($_GET['action']) && 
        $_GET['action'] === 'edit') {
            $word_name = Words::get($_GET['word'])['word'];
            $word_translate = Words::get($_GET['word'])['translate'];
        }

        echo '
        <div class="app">
        
            <div class="app_header">
                <form method="POST">

                    <div class="app_categories_form">
                        <input type="text" name="category_name" placeholder="Category name" />
                        <button name="category_add">Add</button>
                    </div>

                    <div class="app_words_form">
                        <input 
                            type="text" 
                            name="word_name" 
                            placeholder="Word" 
                            value="' . (!empty($word_name) ? $word_name : '') . '" 
                        />
                        <input 
                            type="text" 
                            name="word_translate" 
                            placeholder="Translate" 
                            value="' . (!empty($word_translate) ? $word_translate : '') . '" 
                        />
                        ' . (!empty($word_name) ? '<button name="word_save">Save</button>' : '<button name="word_add">Translate & Add</button>') . '
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
