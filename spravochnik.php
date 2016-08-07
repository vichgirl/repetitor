<?php
require_once 'require/connection.php';
require_once 'require/Object/subjectsObj.php';
require_once 'require/Object/handbooksObj.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Справочник</title>
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
            <div class="flex-item col-3-4">
                <select id='subject' class='pole hidden pc-hide'>
                  <option value=''>Выберите предмет</option>
                  <?php
                      $subjects = Subjects::select_all();
                      if (!$subjects) die($connection->error);

                      $rows_subjects = $subjects->num_rows;

                      for ($j = 0; $j < $rows_subjects; ++$j)
                      {
                          $subjects->data_seek($j);
                          $row_subject = $subjects->fetch_array(MYSQLI_ASSOC);

                          $output = "<option value='";
                          $output .= $row_subject['id'];
                          $output .= "'>";
                          $output .= $row_subject['name_subject'];
                          $output .= "</option>";
                          echo $output;
                    }
                ?>
                </select>

                <select id='theme' class='pole hidden pc-hide'>
                </select>

                <div id='text' class='text'>
                    <p>В данном разделе Вы найдете справочный материал по математике, начиная с начальной школы. Это и формулы, и разбор отдельных тем. </p>
                </div>
            </div>
            <div class="flex-item col-1-4 tel-hide">
                <?php
                    for ($j = 0; $j < $rows_subjects; ++$j)
                    {
                        $subjects->data_seek($j);
                        $row_subject = $subjects->fetch_array(MYSQLI_ASSOC);

                        $output = '<h2>';
                        $output .= $row_subject['name_subject'];
                        $output .= '</h2>';

                        $handbooks = Handbooks::select_handbooks_for_subject($row_subject['id']);
                        if (!$handbooks) die($connection->error);

                        $rows_handbooks = $handbooks->num_rows;

                        $output .= '<ul class="zadania hidden">';

                        for ($i = 0; $i < $rows_handbooks; ++$i)
                        {
                            $handbooks->data_seek($i);
                            $rows_handbook = $handbooks->fetch_array(MYSQLI_ASSOC);
                            $output .= '<li id = "';
                            $output .= $rows_handbook['id'];
                            $output .= '">';
                            $output .= $rows_handbook['name'];
                            $output .= '</li>';
                        }

                        $output .= '</ul>';

                        echo $output;

                    };
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

            $('.col-1-4 h2').on('click', function() {
                $(this).next('.zadania').toggleClass( 'hidden' );
            })

            $('.zadania li').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'require/load_handbook.php',
                    data: {id: $(this).attr('id')},
                    dataType:'html',
                    success: function(html){
                        $('#text').html(html);
                    }
                });
            });

            $('#subject').change(function(){
              $.ajax({
                  type: 'POST',
                  url: 'require/load_themes.php',
                  data: {id_subject: document.getElementById('subject').value},
                  dataType:'html',
                  success: function(html){
                      $('#theme').html(html);
                      $('#theme').val('choice');
                      $('#text').html();
                      $('#theme').removeClass('hidden');
                  }
              });
          	});

            $('#theme').change(function() {
                $.ajax({
                    type: 'POST',
                    url: 'require/load_handbook.php',
                    data: {id: document.getElementById('theme').value},
                    dataType:'html',
                    success: function(html){
                        $('#text').html(html);
                    }
                });
            });
        });
    </script>
</body>
</html>
