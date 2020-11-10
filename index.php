<?php
// Приложение по изучению англ. языка
// Добавление слов с переводом по категориям 
// Перевод выполнить по API - V
// Данные (слова) будем хранить в файлах (JSON) - V

require_once './classes/English.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English App</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<?php English::view(); ?>
    
</body>
</html>