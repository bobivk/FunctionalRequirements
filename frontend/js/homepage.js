function openProjectForm() {
    document.getElementById("modal").style.display = "block";
}

function closeForm() {
    document.getElementById("project-form").reset();
    document.getElementById("modal").style.display = "none";
}

document.getElementById("project-form").addEventListener('submit', (event) => {
    const fields = document.querySelectorAll(".project-input");
    const data = {};
    fields.forEach(field => {
        data[field.name] = field.value;
    });
    const form = document.getElementById("project-form");
    const checked = form.querySelector('input[name=status]:checked');
    data["status"] = checked.value;
    fetch("http://localhost/FunctionalRequirements/backend/api/projects/save-project.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then((response) => {
            if (response.status == 403 || response.status == 401) {
                alert("Нужни са администраторски права за извършване на това действие.");
            }
            response.json();
        })
        .then((responseJson) => {
            closeForm();
            //success message
        })
});

let projectsTableBody = document.getElementById("project-table-body");

const projects = fetch("http://localhost/FunctionalRequirements/backend/api/projects/get-projects.php")
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        let projects = [];
        data.forEach((projectJson) => {
            let project = new Project(projectJson.id, projectJson.name, projectJson.number, projectJson.description, projectJson.status);
            let projectRow = document.createElement("tr");
            attachListener(projectRow, project.id);

            const projectNumberTd = document.createElement("td");
            projectNumberTd.innerHTML = project.number;
            projectRow.appendChild(projectNumberTd);

            const projectNameTd = document.createElement("td");
            projectNameTd.innerHTML = project.name;
            projectRow.appendChild(projectNameTd);
            const projectStatusTd = document.createElement("td");
            const projectStatusColor = document.createElement("span");
            projectStatusColor.classList.add("status");
            if (project.status == "незапочнат") {
                projectStatusColor.classList.add("grey");
            } else if (project.status == "чернова") {
                projectStatusColor.classList.add("purple");
            } else {
                projectStatusColor.classList.add("light-purple");
            }
            projectStatusTd.appendChild(projectStatusColor);
            projectStatusTd.innerHTML += project.status;
            projectRow.appendChild(projectStatusTd);

            projectsTableBody.appendChild(projectRow);
            projects.push(project);
        });
        document.getElementById("numberOfProjects").innerHTML = projects.length;
        fetchRequirementCount("Функционално", document.getElementById("numberOfFuncRequirements"));
        fetchRequirementCount("Нефункционално", document.getElementById("numberOfNonFuncRequirements"));
        return projects;
    });


function attachListener(item, projectId) {
    item.addEventListener('click', (event) => {
        location.href = 'http://localhost/FunctionalRequirements/frontend/html/requirements.html?projectId=' + projectId; //open page of this project with its id
    });
}



function fetchRequirementCount(type, element) {
    fetch("http://localhost/FunctionalRequirements/backend/api/requirements/get-requirements-count.php?type=" + type)
    .then((response) => {
        return response.json();
    })
    .then((count) => {
        element.innerHTML = count;
    });
}

const menuItems = document.querySelectorAll(".list");
menuItems.forEach((item) => {
    item.addEventListener('mouseover', (event) => {
        menuItems.forEach((otherItem) => {
            if(otherItem.classList.contains("avtive-hover")){
                otherItem.classList.remove("active-hover");
            }
            if(otherItem.firstElementChild.classList.contains("active-hover")) {
                otherItem.firstElementChild.classList.remove("active-hover");
            }
        });
        item.classList.add("active-hover");
        item.firstElementChild.classList.add("active-hover");
    });

    item.addEventListener('mouseout', (event) => {
        item.classList.remove("active-hover");
        item.firstElementChild.classList.remove("active-hover");
    });
});


function logout() {
    location = "http://localhost/FunctionalRequirements/frontend/html/register.html";
}