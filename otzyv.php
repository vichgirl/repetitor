<?php
require_once 'require/connection.php';
require_once 'require/Object/reviewsObj.php';
require_once 'require/form_function.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Отзывы учеников</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100&subset=cyrillic,latin">
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
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
                <h2 class='article-title'>Отзывы учеников и их родителей</h2>

                <?php
                    require_once 'require/CRUD/add_otzyv.php';
                ?>

                <div class='table otz-table'>
                    <form action='otzyv.php' method='post' onSubmit='return validate(this)'>
                        <div class='row otz-row'>
                            <div class='cell'><label for='name'>Имя:</label></div>
                            <div class='cell otz-cell'><input id='name' class='pole' name='name' type="text" maxlength="60" pattern='^[А-Яа-яЁё\s]+$' required></div><br>
                        </div>
                        <div class='row otz-row'>
                            <div class='cell'><label for='otzyv'>Отзыв:</label></div>
                            <div class='cell otz-cell'><textarea id='otzyv' class='pole' name='otzyv' rows='12em' required></textarea></div><br>
                        </div>
                        <div class='row otz-row'>
                            <div class='cell'></div>
                            <div class='cell'><button class='button' name='add'>Оставить отзыв</button></div>
                        </div>
                    </form>
                </div>

                <?php
                $reviews = Reviews::select_check_review();
                if (!$reviews) die($connection->error);
                $count = $reviews->num_rows;

                $num = 3;
                @$page = $_GET['page'];
                $total = (($count - 1) / $num) + 1;
                $total = intval($total);
                $page = intval($page);
                if(empty($page) or $page < 0) $page = 1;
                if($page > $total) $page = $total;
                $start = $page * $num - $num;
                if ($start < 0) { $start = 0;}
                if ($page!=1 and $total > 3) {
                    $firstPage = '<a class="page" href=?&page=1><img src="img/two-left-arrows.svg"/></a> <a class="page" title="предыдущая"  href=?&page='. ($page - 1) .'><img src="img/left-arrow.svg"/></a> ';
                }
                if ($page!=$total and $total > 3) {
                    $lastPage = ' <a class="page" title="следующая" href=?&page='. ($page + 1) .'><img src="img/right-arrow.svg"/></a> <a class="page" href=?&page=' .$total. '><img src="img/two-right-arrows.svg"/></a>';
                }
                if ($total > 3 and $page > 4) { $toch = '<span> .... </span> '; }
                $page2 = $total - $page;
                if ($total > 3 and $page2 >= 4) { $toch2 = ' <span> .... </span>'; }

                if($page - 2 > 0) $page2left = ' <a class="page" href=?&page='.($page - 2).'>'.($page - 2).'</a> ';
                if($page - 1 > 0) $page1left = ' <a class="page" href=?&page='.($page - 1).'>'.($page - 1).'</a> ';
                if($page + 2 <= $total) $page2right = ' <a class="page" href=?&page='.($page + 2).'>'.($page + 2).'</a> ';
                if($page + 1 <= $total) $page1right = ' <a class="page" href=?&page='.($page + 1).'>'.($page + 1).'</a> ';
                ?>


                <?php
                    $reviews = Reviews::select_check_review_for_num($start,$num);
                    if (!$reviews) die($connection->error);

                    $rows = $reviews->num_rows;

                    for ($j = 0; $j < $rows; ++$j)
                    {
                        $reviews->data_seek($j);
                        $row = $reviews->fetch_array(MYSQLI_ASSOC);

                        $output = "<section class='otzyv'>";
                        $output .= "<div class='col-1-6'>";
                        $output .= "<h3>";
                        $output .= $row['name_user'];
                        $output .= "</h3>";
                        if ($row['begin_date']!='0000-00-00' and $row['end_date']!='0000-00-00') {
                            $output .= "<p class='tel-hide'>Период обучения: ";
                            $output .= strftime('%B %Y',strtotime($row['begin_date']));
                            $output .= " - ";
                            $output .= strftime('%B %Y',strtotime($row['end_date']));
                            $output .= " гг</p>";
                        }

                        if ($row['foto']!==null) {
                            $output .= "<p class='foto-otzyv tel-hide'>Фото отзыва</p>";
                            $output .= "<div class='overlay hidden'>";
                            $output .= "<div class='block'>";
                            $output .= "<img class='close close-foto' src='img/close.svg'/>";
                            $output .="<img class='img-otzyv' src='";
                            $output .=$row['foto'];
                            $output .="' alt='Отзыв'/>";
                            $output .= "</div>";
                            $output .= "</div>";
                        }

                        $output .= "</div>";
                        $output .= "<div class='col-5-6'>";
                        $output .= "<p>";
                        $output .= $row['text'];
                        $output .="</p>";
                        $output .= "</div>";
                        $output .= "</section>";
                        echo $output;
                    };

                ?>

                <?php
                    // Вывод меню если страниц больше одной
                if ($total > 1)
                {
                    Error_Reporting(E_ALL & ~E_NOTICE);
                    echo "<center><div class=navbar>";
                    echo $firstPage.$toch.$page2left.$page1left.'<span class="page active-page">'.$page.'</span>'.$page1right.$page2right.$toch2.$lastPage;
                    echo "</div><br /></center>";
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
                $(this).next('.overlay').toggleClass( 'hidden' );
            });

            $('.close-menu').on('click', function() {
                $(this).parents('.overlay').toggleClass( 'hidden' );
            });

            $('#btn-success').on('click', function(event){
                $('#success').fadeOut('slow', function(event){
                    $(this).remove();
                });
            });

            $('#btn-error').on('click', function(event){
                $('#error').fadeOut('slow', function(event){
                    $(this).remove();
                });
            });

            $('.foto-otzyv').on('click', function() {
                $(this).next('.overlay').toggleClass( 'hidden' );
            });

            $('.close-foto').on('click', function() {
                $(this).parents('.overlay').toggleClass( 'hidden' );
            });
        });
    </script>
</body>
</html>
