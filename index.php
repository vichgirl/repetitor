<?php
require_once 'require/connection.php';
require_once 'require/Object/reviewsObj.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Репетитор по математике</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100&subset=cyrillic,latin">
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src='js/slider.js'></script>
</head>
<body>
    <header class='container'>
        <section class='content head'>
            <h1 class='logo'>
            <a href="index.php">Репетитор <br> по математике</a>
          </h1>

          <nav>
              <ul class='menu main-menu tel-hide'>
                  <li><a href="lesson.html">Занятия</a></li>
                  <li>
                      <a>Материалы</a>
                      <ul class='sub-menu'>
                          <li><a href="razbor-zadanij.php">Разбор заданий</a></li>
                          <li><a href="spravochnik.php">Справочник</a></li>
                          <li><a href="demo.php">Демонстрационные варианты</a></li>
                      </ul>
                  </li>
                  <li><a href="otzyv.php">Отзывы</a></li>
                  <li><a href="contact.html">Контакты</a></li>
              </ul>
          </nav>

          <div class='contact tel-hide'>
              <h2>Тел.: 8-914-433-7871</h2>
              <p>zubkova_v.v@mail.ru</p>
          </div>

          <div class='contact_abs tel-hide'>
              <h2>Тел.: 8-914-433-7871</h2>
          </div>

          <img class='menu-tel-icon' src='img/menu.svg'/>
          <div class='overlay hidden'>
              <img class='close close-menu' src='img/close-button.svg'/>
              <nav class='block'>
                  <ul class='menu menu-tel'>
                      <li><a href="lesson.html">О занятиях</a></li>
                      <li><a href="razbor-zadanij.php">Разбор заданий</a></li>
                      <li><a href="spravochnik.php">Справочник</a></li>
                      <li><a href="demo.php">Демонстрационные варианты</a></li>
                      <li><a href="otzyv.php">Отзывы</a></li>
                      <li><a href="contact.html">Контакты</a></li>
                  </ul>
              </nav>
          </div>

      </section>
    </header>

    <main class='container'>
        <section class='content info'>
            <div class="flex-item col-2-3">
                <h2>Обо мне</h2>
                <p>Добро пожаловать на личный сайт репетитора по математике Виктории Вячеславовны Зубковой.</p>
                <p>В течение пяти лет провожу занятия с учениками 3-11 классов. Это и устранение пробелов знаний, и целенаправленная подготовка к сдаче ОГЭ, ЕГЭ. К каждому ученику, к каждому занятию подхожу очень ответственно и внимательно. Всегда провожу первоначальную диагностику уровня знаний ученика, определяю пробелы знаний в школьной программе, индивидуальные способности к обучению.  На основе этих данных составляю индивидуальный план обучения. </p>
                <p>На сайте вы найдете много полезной информации: теоретический материал, справочники, примеры решения задач, информацию о процедуре проведения ОГЭ и ЕГЭ.</p>
            </div>
            <div class="flex-item col-1-3 tel-hide">
                <h2>Отзывы</h2>
                <div id="slider">
                    <?php
                    $reviews = Reviews::select_review_with_photo();
                    if (!$reviews) die($connection->error);

                    $rows = $reviews->num_rows;

                    for ($j = 0; $j < $rows; ++$j)
                    {
                        $reviews->data_seek($j);
                        $row = $reviews->fetch_array(MYSQLI_ASSOC);

                        $output = '<img src="';
                        $output .= $row['foto'];
                        $output .= '" alt="Отзыв ';
                        $output .= $row['name_user'];
                        $output .= '" alt="Отзыв"/>';
                        echo $output;

                    }
                    ?>
                </div>
                <a class='more' href="otzyv.php">Подробнее</a>
            </div>
        </section>
    </main>

    <footer class='container'>
        <section class='content foot'>
            <nav>
                <ul class='menu footer-menu'>
                    <li><a href='lesson.html'>О занятиях</a></li>
                    <li><a href='razbor-zadanij.php'>Разбор заданий</a></li>
                    <li class='tel-hide tablet-hide'><a href='spravochnik.php'>Справочник</a></li>
                    <li class='tel-hide tablet-hide'><a href='demo.php'>Варианты</a></li>
                    <li><a href='otzyv.php'>Отзывы</a></li>
                    <li><a href='contact.html'>Контакты</a></li>
                </ul>
            </nav>
        </section>
    </footer>

    <script>
        $(document).ready(function() {
            $('.overlay').addClass('hidden');

            $('.menu-tel-icon').on('click', function() {
                $('.overlay').toggleClass( 'hidden' );
            });

            $('.close-menu').on('click', function() {
                $('.overlay').toggleClass( 'hidden' );
            });

            $('#slider').cycle({
                fx: 'fade',
                rev: 5,
            });
        });
    </script>
</body>
</html>
