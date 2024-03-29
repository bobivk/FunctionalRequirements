<?php
require_once("../../backend/session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title>Тема</title>
    <script src="https://kit.fontawesome.com/4d3f93d2d2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/requirements.css">
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
                <li>
                    <a href="./homepage.php" class="active"><span class="las la-igloo"></span>
                        <span>Табло</span></a>
                </li>
                <li>
                    <a href="./functional-requirements.php"><span class="las la-question"></span></span>
                        <span>Функционални изисквания</span></a>
                </li>
                <li>
                    <a href="./non-functional-requirements.php"><span class="las la-question"></span></span>
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
                <input id="search" placeholder="Търсене" type="search" class="form-control search-input" data-table="requirements-table">
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
        <div class="card" >
            <div class="modify-project-info-btns">
            <?php if($_SESSION['userRoleId'] == 1) {
                        echo "<button id='delete-project' class='action-button' onclick='deleteProject()'><i class='las la-trash-alt'></i> Изтрий проект</button>
                        <button id='edit-project' class='action-button' onclick='openProjectModal()'><i class='las la-edit'></i> Редактирай проект</button>";
            }
            ?>
                
            </div>
            <div id="project">
                <div class="card-header">
                    <h2 id="project-name"></h2>
                </div>

                <p id="project-description"></p>
                <p id="project-status"></p>
            </div>
        </div>

        <div class="card team-members">
            <div class="team-member-btns">
                <button id="add-member" class="action-button" onclick="addMember()"><i class="fa-solid fa-user-plus"></i> Запиши се</button>
                <button id="remove-member" class="action-button" onclick="removeMember()"><i class="fa-solid fa-user-minus"></i> Отпиши се</button>
            </div>

            <div id="team">
                <div class="card-header">
                    <h3 id="team-title">Екип:</h3>
                </div>
                
                <div clas="card-body" id="members-list">
                    <ul id="members">
                    </ul>                    
                </div>
            </div>
        </div>

        <div class="card upload-project-solution-card">
            <div class="upload-project-solution-btns">
                <button id="upload-project-solution" class="action-button" onclick="openImportProjectSolModal()"><i class="fa-solid fa-upload"></i> Прикачи решение</button>
                <button id="remove-project-solution" class="action-button" onclick="removeProjectSolution()"><i class="las la-trash-alt"></i> Премахни решение</button>
            </div>

            <div id="project-solution">
                <div class="card-header">
                    <h3 id="project-solution-title">Прикачено решение: </h3>
                </div>
            </div>
        </div>
        
        <h4 class="deleted-msg" id="req-deleted-msg">Изискването е изтрито успешно.</h4>

        <div class="recent-grid">
            <div class="projects">
                <div class="card">
                    <div class="card-header">
                        <h3> Изисквания </h3>
                        <div class="error" id="admin-required-error"></div>
                        <div class="card-header-btns">
                            <button id="create-requirement-btn" class="action-button" onclick="openRequirementsModal()"><i class="fa-regular fa-square-plus"></i> Добави изискване</button>
                            <button onclick="openImportReqModal()"><i class="fa-solid fa-upload"></i> Импорт</button>
                            <button id="export-requirements-btn"><i class="fa-solid fa-download"></i> Експорт</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" id="requirements-container">
                            <table width="100%" id="functional-requirements" class="requirements-table">
                                <thead>
                                    <tr>
                                        <td class="table-sort-btn req-th" id="req-name">Име</td>
                                        <td class="table-sort-btn req-th" id="req-priority">Приоритет</td>
                                        <td class="table-sort-btn req-th" id="req-layer">Слой</td>
                                        <td class="table-sort-btn req-th" id="req-story">User Story</td>
                                        <td class="table-sort-btn req-th" id="req-description">Описание</td>
                                        <td class="table-sort-btn req-th" id="req-tags">Тагове</td>
                                        <td class="table-sort-btn req-th" id="req-type">Тип</td>
                                        <td class="req-th">Действие</td>
                                    </tr>
                                </thead>
                                <tbody id="requirements-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="req-modal">
            <div class="form-popup" id="requirement-form">
                <form id="form-container">
                    <h2>Ново изискване</h2>

                    <label for="type">Тип:</label>
                    <select name="type" class="requirement-input form-input-field" id="type">
                        <option value="Функционално">Функционално</option>
                        <option value="Нефункционално">Нефункционално</option>
                    </select>

                    <label for="name">Име:</label>
                    <input type="text" class="requirement-input form-input-field" placeholder="Име на изискването" name="name" required>

                    <label for="priority">Приоритет:</label>
                    <select name="priority" class="requirement-input form-input-field" id="priority">
                        <option value="Must Have">Must Have</option>
                        <option value="Nice To Have">Nice To Have</option>
                        <option value="Improvement">Improvement</option>
                    </select>

                    <label for="layer">Слой:</label>
                    <select name="layer" class="requirement-input form-input-field" id="layer">
                        <option value="Бизнес логика">Бизнес логика</option>
                        <option value="Клиентски">Клиентски</option>
                        <option value="Рутиране">Рутиране</option>
                        <option value="Бази данни">Бази данни</option>
                        <option value="Тестване/Инсталиране">Тестване/Инсталиране</option>
                        </select>

                    <label for="story">User story:</label>
                    <input type="text" class="requirement-input form-input-field" placeholder="Напр. 'Като нов потребител, искам да се регистрирам в сайта.'" name="story" required>

                    <label for="description">Описание:</label>
                    <input type="text" class="requirement-input form-input-field" placeholder="Описание на изискването" name="description" required>

                    <label for="tags">Тагове:</label>
                    <input type="text" class="requirement-input form-input-field" placeholder="Напр. #login" name="tags">

                    <div class="add-requirement-btns">
                        <button id="add-requirement-btn" class="btn action-button"><i class="fa-solid fa-plus"></i> Добави</button>
                        <button id="cancel-add-requirement-btn" type="button" class="btn cancel action-button" onclick="closeRequirementsModal()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                    </div>
                </form>
            </div>    
        </div>

        <div id="edit-req-modal">
            <div class="form-popup" id="requirement-edit-form">
                <form id="form-container">
                    <h2>Редактирай изискване</h2>

                    <label for="type">Тип:</label>
                    <select name="type" class="requirement-edit-input form-input-field" id="edit-req-type">
                        <option value="Функционално">Функционално</option>
                        <option value="Нефункционално">Нефункционално</option>
                    </select>

                    <label for="name">Име:</label>
                    <input type="text" id="edit-req-name" class="requirement-edit-input form-input-field" placeholder="Име на изискването" name="name" required>

                    <label for="priority">Приоритет:</label>
                    <select name="priority" class="requirement-edit-input form-input-field" id="edit-req-priority">
                        <option value="Must Have">Must Have</option>
                        <option value="Nice To Have">Nice To Have</option>
                        <option value="Improvement">Improvement</option>
                    </select>

                    <label for="layer">Слой:</label>
                    <select name="layer" class="requirement-edit-input form-input-field" id="edit-req-layer">
                        <option value="Бизнес логика">Бизнес логика</option>
                        <option value="Клиентски">Клиентски</option>
                        <option value="Рутиране">Рутиране</option>
                        <option value="Бази данни">Бази данни</option>
                        <option value="Тестване/Инсталиране">Тестване/Инсталиране</option>
                        </select>

                    <label for="story">User story:</label>
                    <input type="text" id="edit-req-story" class="requirement-edit-input form-input-field" placeholder="Напр. 'Като нов потребител, искам да се регистрирам в сайта.'" name="story" required>

                    <label for="description">Описание:</label>
                    <input type="text"  id="edit-req-description" class="requirement-edit-input form-input-field" placeholder="Описание на изискването" name="description" required>

                    <label for="tags">Тагове:</label>
                    <input type="text" id="edit-req-tags" class="requirement-edit-input form-input-field" placeholder="Напр. #login" name="tags">

                    <div class="edit-requirement-btns">
                        <button id="edit-save-requirement-btn" class="btn  action-button"><i class="las la-save"></i></i> Запази</button>
                        <button id="cancel-edit-requirement-btn" type="button" class="btn cancel action-button" onclick="closeEditRequirementsModal()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="project-modal">
            <div class="form-popup" id="project-form">
                <form id="form-container">
                    <h2>Редактиране на проект</h2>
                    <label for="number">Номер на тема:</label>
                    <input type="text" id="project-input-number" class="project-input form-input-field" name="number" required>

                    <label for="name">Име:</label>
                    <input type="text" id="project-input-name" class="project-input form-input-field" placeholder="Име на проекта" name="name" required>

                    <label for="description">Описание:</label>
                    <input type="text" id="project-input-description" class="project-input form-input-field" placeholder="Описание на проекта" name="description" required>

                    <label for="proj-status">Статус:</label>
                    <select name="status" id="project-input-status" class="project-input form-input-field" id="proj-status">
                        <option value="незапочнат">незапочнат</option>
                        <option value="чернова">чернова</option>
                        <option value="завършен">завършен</option>
                    </select>

                    <div class="add-requirement-btns">
                        <button id="save-project-btn" class="btn action-button"><i class="las la-save"></i></i> Запази</button>
                        <button id="cancel-save-project-btn" onclick="closeProjectModal()" type="button" class="btn cancel action-button"><i class="fa-solid fa-xmark"></i> Затвори</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modal-import-requirements">
            <div id="import-modal-req">
                <h2>Импорт на изискване</h2>
                <div>
                    <h4>Изберете .csv файл с изисквания:</h4>
                    <form id="import-req-form" action="" method="post" enctype="multipart/form-data">
                        <input type="file" id="requirements-import-file"/>
                        <div class="import-req-modal-btns">
                            <button id="import-chosen-req-file-btn"> <i class="fa-solid fa-upload"></i> Импорт</button>
                            <button id="cancel-import-req-btn" type="button" class="btn cancel" onclick="closeImportModal()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modal-import-project-solution">
            <div id="import-modal-project-sol">
                <h2>Прикачи проект</h2>
                <div>
                    <h4>Изберете файл за прикачване:</h4>
                    <form id="import-project-sol-form" action="" method="post" enctype="multipart/form-data">
                        <input type="file" id="project-sol-import-file"/>
                        <div class="import-project-sol-modal-btns">
                            <button id="import-chosen-project-sol-file-btn"> <i class="fa-solid fa-upload"></i> Прикачи</button>
                            <button id="cancel-import-project-sol-btn" type="button" class="btn cancel" onclick="closeImportProjectSolModal()"><i class="fa-solid fa-xmark"></i> Затвори</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

</body>
<script src="../js/requirements/requirements.js" defer></script>
<script src="../js/project.js" defer></script>
<script src="../js/TableCsvExporter.js" defer></script>

</html>