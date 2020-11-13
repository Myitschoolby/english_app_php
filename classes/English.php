<?php

require_once 'Categories.php';
require_once 'Words.php';

class English {

    private static function requests() {
        Categories::get_data();
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

        if (isset($_POST['category_add'])) {
            Categories::add($_POST['category_name']);
        }

        if (isset($_POST['category_save'])) {
            if (Categories::edit($_GET['category'], $_POST['category_name'])) {
                header('Location: /');
                exit;
            }
        }

        if (isset($_GET['category']) && 
            isset($_GET['action']) &&
            $_GET['action'] === 'delete'
        ) {
            if (Categories::delete($_GET['category'])) {
                header('Location: /');
                exit;
            }
        }
    }

    private static function get_categories() {
        $categories_data = Categories::get();

        $html = '';

        foreach ($categories_data as $index => $category) {
            $html .= '<li class="category">
                <a href="?category=' . $index . '">' . $category . '</a>
                <div class="category_btns">
                    <a href="/?category=' . $index . '&action=edit">Edit</a>
                    <a href="/?category=' . $index . '&action=delete">X</a>
                </div>
            </li>';
        }

        return !empty($html) ? '<ul>
            <li><a href="/">Home</a></li>
            ' . $html . '
        </ul>' : '';
    }

    private static function get_words() {
        $words_data = Words::get();

        $html = '';

        foreach ($words_data as $index => $word) {
            if (isset($_GET['category']) && 
                ($_GET['category'] == '' || 
                $_GET['category'] != $word['category'])
            ) continue;

            $category_name = '';
            if ($word['category'] !== '') $category_name = Categories::get($word['category']);

            $html .= '<li class="word">
                <div class="word_name">' . $word['word'] . '</div>
                <div class="word_translate">' . $word['translate'] . '</div>
                ' . (!empty($category_name) ? '<div class="word_category">' . $category_name .  '</div>' : '') . '
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

        if (isset($_GET['category']) && 
        isset($_GET['action']) && 
        $_GET['action'] === 'edit') {
            $category_name = Categories::get($_GET['category']);
        }

        echo '
        <div class="app">
        
            <div class="app_header">
                <form method="POST">

                    <div class="app_categories_form">
                        <input 
                            type="text" 
                            name="category_name" 
                            placeholder="Category name"
                            value="' . (!empty($category_name) ? $category_name : '') . '" 
                    />
                    ' . (!empty($category_name) ? '<button name="category_save">Save</button>' : '<button name="category_add">Add</button>') . '
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
