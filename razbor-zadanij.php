<?php
require_once 'require/connection.php';
require_once 'require/Object/examsObj.php';
require_once 'require/Object/tasksObj.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Разбор заданий</title>
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
            <div class='flex-item col-4-5'>
                <select id='exam' class='pole hidden pc-hide'>
                  <option value=''>Выберите экзамен</option>
                  <?php
                    $exams = Exams::select_all();
                    if (!$exams) die($connection->error);

                    $rows_exams = $exams->num_rows;

                    for ($j = 0; $j < $rows_exams; ++$j)
                    {
                        $exams->data_seek($j);
                        $row_exam = $exams->fetch_array(MYSQLI_ASSOC);

                		$output = "<option value='";
                        $output .= $row_exam['id'];
                        $output .= "'>";
                		$output .= $row_exam['name_exam'];
                		$output .= "</option>";
                		echo $output;
                	}
                  ?>
                </select>

                <select id='zadanie' class='pole hidden pc-hide'>
                </select>

                <div id='text' class='text'>
                    <p>В данном разделе разобраны типовые задачи, которые встречаются на экзамене. Рассмотрены все основные моменты решения, приемы, которые позволяют быстро и верно решить задачу, а также указаны типовые ошибки, которые допускают выпускники.</p>
                    <p>Выберите экзамен, к которому вы готовитесь, а затем задание.</p>
                </div>
            </div>
            <div class="flex-item col-1-5 tel-hide">
                <?php
                    for ($j = 0; $j < $rows_exams; ++$j)
                    {
                        $exams->data_seek($j);
                        $row_exam = $exams->fetch_array(MYSQLI_ASSOC);

                        $output = '<h2>';
                        $output .= mb_substr($row_exam['name_exam'], 0, 3);
                        if (mb_strlen($row_exam['name_exam']) > 3)
                        {
                            $output .= ' <span>';
                            $output .= substr($row_exam['name_exam'], strpos($row_exam['name_exam'], ' '));
                            $output .= '</span>';
                        }
                        $output .= '</h2>';

                        $tasks = Tasks::select_tasks_for_exam($row_exam['id']);
                        if (!$tasks) die($connection->error);

                        $rows_tasks = $tasks->num_rows;

                        $output .= '<ul class="zadania hidden">';

                        for ($i = 0; $i < $rows_tasks; ++$i)
                        {
                            $tasks->data_seek($i);
                            $row_task = $tasks->fetch_array(MYSQLI_ASSOC);
                            $output .= '<li id = "';
                            $output .= $row_task['id'];
                            $output .= '">';
                            $output .= $row_task['name_task'];
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

            $('.col-1-5 h2').on('click', function() {
                $(this).next('.zadania').toggleClass( 'hidden' );
            })

            $('.zadania li').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'require/load.php',
                    data: {id_task: $(this).attr('id')},
                    dataType:'html',
                    success: function(html){
                        $('#text').html(html);
                    }
                });
            });

            $('#exam').change(function(){
              $.ajax({
                  type: 'POST',
                  url: 'require/load_task.php',
                  data: {id_exam: document.getElementById('exam').value},
                  dataType:'html',
                  success: function(html){
                      $('#zadanie').html(html);
                      $('#zadanie').val('choice');
                      $('#text').html();
                      $('#zadanie').removeClass('hidden');
                  }
              });
          	});

            $('#zadanie').change(function() {
                $.ajax({
                    type: 'POST',
                    url: 'require/load.php',
                    data: {id_task: document.getElementById('zadanie').value},
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
