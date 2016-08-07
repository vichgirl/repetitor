<?php
require_once 'require/connection.php';
require_once 'require/Object/examsObj.php';
require_once 'require/Object/demoObj.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Демонстрационные варианты</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100&subset=cyrillic,latin">
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
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
            <div class="flex-item">
                <h2 class='article-title'>Демонстрационные варианты</h2>
                <?php
                  $exams = Exams::select_all();
                  if (!$exams) die($connection->error);

                  $rows_exams = $exams->num_rows;

                  for ($j = 0; $j < $rows_exams; ++$j)
                  {
                      $exams->data_seek($j);
                      $row_exam = $exams->fetch_array(MYSQLI_ASSOC);

                      $output = "<h3>";
                      $output .= $row_exam['name_exam'];
                      $output .= "</h3>";


                      $demo = Demo::select_demo_to_exam($row_exam['id']);
                      if (!$demo) die($connection->error);

                      $rows_demo = $demo->num_rows;

                      $output .="<ul>";

                      for ($i = 0; $i < $rows_demo; ++$i)
                      {
                          $demo->data_seek($i);
                          $row_demo = $demo->fetch_array(MYSQLI_ASSOC);

                          $output .="<li><a href='";
                          $output .=$row_demo['url'];
                          $output .="'target='_blank'>Демо ";
                          $output .= $row_demo['year'];
                          $output .=" года</a></li>";
                      }
                      $output .="</ul>";

                      echo $output;

                  }
                ?>


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
        });
    </script>
</body>
</html>
