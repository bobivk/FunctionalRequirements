<?php
require_once("../../backend/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title>Функционални изисквания</title>
    <script src="https://kit.fontawesome.com/4d3f93d2d2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/functional-requirements.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span> <span>Проекти</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li class="list">
                    <a href="./homepage.php" ><span class="las la-igloo"></span>
                        <span>Табло</span></a>
                </li>
                <li class="list active">
                    <a href="#"><span class="las la-question"></span>
                        <span>Функционални изисквания</span></a>
                </li>
                <li class="list">
                    <a href="./non-functional-requirements.php"><span class="las la-question"></span>
                        <span>Нефункционални изисквания</span></a>
                </li>
            </ul>
        </div>

    </div>
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label> Меню
            </h2>
            <div class="user-wrapper">
                <?php if($_SESSION['userRoleId'] == 1) {
                                echo '<i class="fa-solid fa-user-gear" id="accountIcon"></i>';
                        } else {echo '<i class="fa-solid fa-user-graduate" id="accountIcon"></i>';}
                ?>
                <div>
                    <h4 id="userName"><?php echo $_SESSION['username'];?></h4>
                    <small id="userRole">
                        <?php if($_SESSION['userRoleId'] == 1) {
                                echo 'Администратор';
                            } else {echo 'Студент';} ?>
                    </small>
                    <button id="logout-btn" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket"></i> Изход</button>
                </div>
            </div>
        </header>

        <main>
            <h1><i class="las la-clipboard-list"></i> Функционални изисквания</h1>

            <div class="about">
                
                <h2>Що е то функционално изискване?</h2>
                
                <p> Описва функционалност или услуги на системата. </p>
                <p> Зависи от типа на софтуера, очакваните потребители и типа на системата, в която е използван софтуера. </p>
                <p> Потребителските функционални изисквания могат да бъдат твърдения от високо ниво за това, което системата трябва да върши, но системните функционални изисквания трябва да описват подробно услугите. </p>
            </div>

            
            <div class="examples">
                
                <h2>Примери</h2>
                
                <p>Потребителят ще може да търси било то в целия набор от бази от данни, било то в избрана от него част от тях.</p>
                <p>Системата ще осигури подходящи средства за изобразяване (вюъри) на потребителите, за да четат намерените документи.</p>
                <p>На всяка поръчка ще бъде даден уникален идентификатор (ORDER_ID), който ще може да бъде копиран от потребителя в постоянната област на акаунта. </p>
            </div>

            <div class="examples">
                
                <h2>Неточност на изискванията</h2>
                
                <p>Когато изискванията не са формулирани прецизно, могат да възникнат проблеми. </p>
                <p>Разработчиците и потребителите могат да интерпретират двусмислените изисквания по различен начин. </p>
                <p>Да разгледаме термина подходящи вюъри:</p>
                <ul>
                    <li class="normal">Намерения на потребителя – за всеки тип документ – вюър със специално предназначение. </li>
                    <li class="normal">Интерпретация на разработчика – прилага текстов вюър, който показва съдържанието на документа.</li>
                </ul>
            </div>

            <div class="examples">
                
                <h2>Пълнота и съвместимост на изискванията</h2>
                
                <p><span class="definition">Пълнота:</span> Трябва да се включат описания на всички изисквани функции. </p>
                <p><span class="definition">Съвместимост:</span> Не трябва да има конфликти и противоречия при описанието на системните функции. </p>
                <p>На практика е невъзможно да се състави пълен и непротиворечив документ на изискванията (техническо задание). </p>
            </div>

            <div class="examples">
                
                <h2>Инженеринг на изискванията</h2>
                
                <p>Процесът на определяне на услугите, които клиентът изисква от системата и на ограниченията, при които тя работи и са разработва.</p>
                <p>Самите изисквания са описания на системните услуги и на ограниченията възникнали по време на процеса на инженеринга на изискванията.</p>
            </div>

            <div class="examples">
                
                <h2>Допълителна литература</h2>
                <ul>
                    <li>[1] "Функционални изисквания". 
                        [<a href="https://www-it.fmi.uni-sofia.bg/courses/HCI/book/c19/functional.htm" target="_blank">https://www-it.fmi.uni-sofia.bg/</a>]
                    </li>
                    <li>[2] "Изисквания - методи и техники за определяне на изискванията".
                        [<a href="https://elearn.uni-sofia.bg/mod/resource/view.php?id=12790" target="_blank">https://elearn.uni-sofia.bg</a>]
                    </li>   
                </ul>
            </div>
        </main>
    </div>
</body>
<script src="../js/requirements/functional-requirements.js" defer></script>

</html>