<?php
require_once("../../backend/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title>Начална страница</title>
    <script src="https://kit.fontawesome.com/4d3f93d2d2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/homepage.css">
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
                <li class="list active">
                    <a href="#" ><span class="las la-igloo"></span>
                        <span>Табло</span></a>
                </li>
                <li class="list">
                    <a href="http://localhost/FunctionalRequirements/frontend/html/functional-requirements.php"><span class="las la-question"></span>
                        <span>Функционални изисквания</span></a>
                </li>
                <li class="list">
                    <a href="http://localhost/FunctionalRequirements/frontend/html/non-functional-requirements.php"><span class="las la-question"></span>
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
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input id="search" placeholder="Търсене" type="search" class="form-control search-input" data-table="projects-table">
            </div>

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
            <div class="tiles">
                <div class="single-tile">
                    <div>
                        <h1 id="numberOfProjects"></h1>
                        <span>Проекти</span>
                    </div>
                    <div>
                        <span class="las la-clipboard-list"></span>
                    </div>
                </div>

                <div class="single-tile">
                    <div>
                        <h1 id="numberOfFuncRequirements"></h1>
                        <span>Функционални изисквания</span>
                    </div>
                    <div>
                        <span class="las la-clipboard-list"></span>
                    </div>
                </div>

                <div class="single-tile">
                    <div>
                        <h1 id="numberOfNonFuncRequirements"></h1>
                        <span>Нефункционални изисквания</span>
                    </div>
                    <div>
                        <span class="las la-clipboard-list"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3> Проекти </h3>
                            <div class="card-header-btns">
                                <button onclick="openProjectForm()"> <i class="fa-regular fa-square-plus"></i> Добави проект</button>
                                <button id="import-btn" onclick="openImportModal()"> <i class="fa-solid fa-upload"></i> Импорт</button>
                                <button id="export-projects-btn"> <i class="fa-solid fa-download"></i> Експорт</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="project-table" width="100%" class="projects-table">
                                    <thead>
                                        <tr>
                                            <td>№</td>
                                            <td>Име на проект</td>
                                            <td>Описание</td>
                                            <td>Статус</td>
                                        </tr>
                                    </thead>
                                    <tbody id="project-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="modal">
                    <div id="add-project-modal">
                        <h2>Добави проект</h2>
                        <div>
                            <form id="project-form" class="form-container">
                                
                                <label class="form-label" for="number">Номер:</label>
                                <input type="text" class="project-input project-input-text" placeholder="Номер на темата" name="number" required>
                                
                                <label class="form-label" for="name">Тема:</label>
                                <input type="text" class="project-input project-input-text" placeholder="Тема на проекта" name="name" required>

                                <label class="form-label" for="description">Описание:</label>
                                <textarea type="text" class="project-input project-input-text" placeholder="Подробно описание на проекта" name="description" required rows="10" cols="20"></textarea>

                                <label class="form-label" for="status">Статус:</label>
                                <input type="radio" class="project-input project-input-radio" id="not-started" name="status" value="незапочнат" required>
                                <label for="not-started">незапочнат</label>

                                <input type="radio" class="project-input project-input-radio" id="draft" name="status" value="чернова" required>
                                <label for="draft">чернова</label>

                                <input type="radio" class="project-input project-input-radio" id="finished" name="status" value="завършен" required>
                                <label for="finished">завършен</label>

                                <div class="add-project-btns">
                                    <button id="add-project-btn" type="submit" class="btn"><i class="fa-solid fa-plus"></i> Добави</button>
                                    <button id="cancel-add-project-btn" type="button" class="btn cancel" onclick="closeForm()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modal-import-project">
                    <div id="import-modal">
                        <h2>Импорт на проекти</h2>
                        <div>
                            <h4>Изберете .csv файл с проекти:</h4>
                            <form id="import-form" action="" method="post" enctype="multipart/form-data">
                                <input type="file" id="project-import-file"/>
                                <div class="import-modal-btns">
                                    <button id="import-chosen-file-btn"> <i class="fa-solid fa-upload"></i> Импорт</button>
                                    <button id="cancel-import-btn" type="button" class="btn cancel" onclick="closeImportModal()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

        </main>
        </div>
</body>
<script src="../js/homepage.js" defer></script>
<script src="../js/project.js" defer></script>
<script src="../js/TableCsvExporter.js" defer></script>

</html>