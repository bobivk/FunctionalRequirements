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
    <link rel="stylesheet" href="../css/non-functional-requirements.css">
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
                <li class="list">
                    <a href="./functional-requirements.php"><span class="las la-question"></span>
                        <span>Функционални изисквания</span></a>
                </li>
                <li class="list active">
                    <a href="#"><span class="las la-question"></span>
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
            <h1><i class="las la-clipboard-list"></i> Нефункционални изисквания</h1>

            <div class="about">
                
                <h2>Що е то нефункционално изискване?</h2>
                
                <p> Дефинира свойствата и ограниченията на системата, напр. надеждност, време на реакция, изисквания към външната памет. Ограничения са капацитетът на входно-изходните устройства, представянето на системата и т.н.</p>
                <p> Нефункционалните изисквания могат също да се специфицират изисквания за процеса на разработка. Например, задължително използване на дадена CASE система, програмен език или метод за разработка. </p>
                <p> Те може да са по-важни от функционалните - неизпълнението им може да направи системата безполезна. </p>
            </div>

            <div class="examples">
                
                <h2>Класификация на нефункционалните изисквания</h2>
                
                <p>Изисквания към продукта:</p>
                <ul>
                    <li class="normal">Изисквания, които специфицират че продуктът трябва да има определено поведение, например: скорост на изпълнение, надеждност и т.н.</li>
                </ul>
                <p>Организационни изисквания:</p>
                <ul>
                    <li class="normal">Изисквания, които са следствие от политиката и процедурите на организацията, например: използвани стандарти, изисквания на внедряването и т.н.</li>
                </ul>
                <p>Външни изисквания:</p>
                <ul>
                    <li class="normal">Изисквания, които възникват от фактори, външни на системата и процеса на разработка, например: изисквания за съвместимост с други системи, юридически изисквания и т.н.</li>
                </ul>
            </div>

            <div class="examples">
                
                <h2>Типове нефункционални изисквания</h2>
                
               
                <figure>
                    <img src="../css/schema.jpg">
                    <figcaption id="fig1">Фигура 1. Схема на типовете нефункционални изисквания</figcaption>
                </figure>
            </div>

            <div class="examples">
                
                <h2>Примери</h2>
                
                <p>Достъпност, архивиране, капацитет, съответствие, целостта на данните, задържане на данни, зависимост, внедряване, документация, трайност, ефективност, експлоатабилност, разширяемост, управление на неизправности, толерантност към грешки, оперативна съвместимост, модифицируемост, оперативност, поверителност, четливост, докладване, устойчивост, повторна употреба, мащабируемост, стабилност, проверяемост, производителност, прозрачност, интегративност.</p>
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
<script src="../js/requirements/non-functional-requirements.js" defer></script>

</html>