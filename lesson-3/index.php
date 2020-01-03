<?php

if (empty($_GET)) {
    echo '<div style="text-align: center"><h2>Упс! В адресной строке нет параметров :(</h2>
          <p>Вот фото грустного котика</p>
          <p style="text-align: center"><img src="http://katyaburg.ru/sites/default/files/pictures/prikoly/grustnye_koty_foto_pechalka_11_glavnaya.jpg" style="width: 220px" alt="sad cat"></p>';
} elseif (!isset($_GET['uri']) || !isset($_GET['name'])) {
    echo '<div style="text-align: center"><h2>Супер! Параметры есть, но не те что нужны. Как насчёт указать uri и name?</h2>
          <p>Котик что-то подозревает</p>
          <p style="text-align: center"><img src="http://mignews.com.ua/modules/news/images/articles/changing/5098924-fotoreportazh-kovarnye-koshki-zadumavsh.jpg" style="width: 220px" alt="suspicious cat"></p>';
} elseif (empty($_GET['uri']) || empty($_GET['name'])) {
    echo '<div style="text-align: center"><h2>Эй! Кто-то читить пытается? А ну заполняем uri и name нормально!</h2>
          <p>Не нужно злить кота</p>
          <p style="text-align: center"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQGnRrnt2PLAjQberdLn9JHREcy5fj5vEfQ6e8w_t_t3bJgaYXh" style="width: 220px" alt="angry cat"></p>';
} elseif (!preg_match('/^([-a-zA-Z\s]+)$/', $_GET['name']) || !preg_match('/id\d+/', $_GET['uri'])) {
    echo '<div style="text-align: center"><h2>Ай-ай! Всё не так! Пример uri: id1234567. А name это просто имя, например John Doe</h2>
          <p>Котик устал</p>
          <p style="text-align: center"><img src="https://funik.ru/wp-content/uploads/2018/10/maxresdefault-20-700x394.jpg" style="width: 220px" alt="tired cat"></p>';
} else {
    $uri  = $_GET['uri'];
    $name = $_GET['name'];

    echo '<div style="text-align: center"><h2>Ура! Мы получили всё, что хотели получить!</h2>
          <p>Вот ссылка - <a href="http://lessons.osp/' . $uri . '">' . $name . '</a> и счастливый котик</p>
          <p style="text-align: center"><img src="https://mirabilis.pp.ru/wp-content/uploads/2016/12/Funny-Cat7-4.jpg" style="width: 220px" alt="happy cat"></p>';
}