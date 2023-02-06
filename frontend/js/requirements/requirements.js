class Requirement {
    constructor(id, name, projectId, priority, layer, story, number, description, tags, type) {
        this.id = id;
        this.name = name;
        this.projectId = projectId;
        this.priority = priority;
        this.layer = layer;
        this.story = story
        this.number = number;
        this.description = description;
        this.tags = tags;
        this.type = type;
    }
}
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

let project = fetch("http://localhost/FunctionalRequirements/backend/api/projects/get-project.php?projectId=" + params.projectId)
    .then((response) => {
        return response.json();
    })
    .then((projectJson) => {
        let projectObj = new Project(projectJson.id, projectJson.name, projectJson.number, projectJson.description, projectJson.status);
        let projectName = document.getElementById("project-name");
        projectName.innerHTML = projectObj.number + ". " + projectObj.name;
        let projectDesc = document.getElementById("project-description");
        projectDesc.innerHTML = projectObj.description;
        let projectStatus = document.getElementById("project-status");
        projectStatus.innerHTML = projectObj.status;
    });

// if (isAdmin()) {
//     document.getElementById("edit-project").style.display = "block";
//     document.getElementById("delete-project").style.display = "block";
//     document.getElementById("save-project").style.display = "block";
//     //for each requirement row display edit/delete buttons
// }

// async function isAdmin() {
//     const response = await fetch("http://localhost/FunctionalRequirements/backend/api/users/is-admin.php");
//     const data = await response.json();
//     return data["isAdmin"];
// }

fetchRequirements();

const requirementButton = document.getElementById('add-requirement-btn');
requirementButton.addEventListener('click', (event) => {
    const data = {};
    const fields = document.querySelectorAll('.requirement-input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });
    data["project_id"] = params.projectId;
    fetch('http://localhost/FunctionalRequirements/backend/api/requirements/save-requirement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then((response) => {
            closeModal();
            location.reload();
        });
        event.preventDefault();
});

const deleteProjectButton = document.getElementById("delete-project");
deleteProjectButton.addEventListener('click', (event) => {
    console.log("deleting");
    let sureToDelete = confirm("Сигурни ли сте, че искате да изтриете този проект?");
    if (sureToDelete) {
        let ableToDelete = true;
        fetch('http://localhost/FunctionalRequirements/backend/api/requirements/delete-requirements-of-project.php?projectId=' + params.projectId, {
            method: 'DELETE'
        }).then((response) => {
            if (response.status == 403) {
                ableToDelete = false;
            }
        });
        if (ableToDelete) {
            fetch('http://localhost/FunctionalRequirements/backend/api/projects/delete-project.php?projectId=' + params.projectId, {
                    method: 'DELETE'
                })
                .then((response) => {
                    //message проектът е изтрит успешно
                    location = 'http://localhost/FunctionalRequirements/frontend/html/homepage.html';
                });
        } else {
            alert("Нужни са администраторски права за изтриване на този проект.");
        }
    }
    event.preventDefault();
});

const editProjectButton = document.getElementById("edit-project");
editProjectButton.addEventListener('click', (event) => {
    document.getElementById('project').toggleAttribute("contenteditable");
    document.getElementById('save-project').style.display = "block";
    event.preventDefault();
});

const saveProjectButton = document.getElementById("save-project");
saveProjectButton.addEventListener('click', (event) => {
    document.getElementById('project').setAttribute('contenteditable', 'false');
    let projectInput = document.querySelectorAll("project-input");
    fetch('http://localhost/FunctionalRequirements/backend/api/projects/', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(projectInput)
        })
        .then((response) => {
            if (response.status == 403) {
                alert("Нужни са администраторски права за промяна на този проект");
            }
        });
    event.preventDefault();
});

function fetchRequirements() {
    fetch("http://localhost/FunctionalRequirements/backend/api/requirements/get-requirements.php?projectId=" + params.projectId)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            let requirements = [];
            data.forEach((req) => {
                //id, name, projectId, priority, layer, story, number, description, tags, type
                let requirement = new Requirement(req.id, req.name, req.project_id, req.priority, req.layer, req.story, req.number, req.description, req.tags, req.type);
                requirements.push(requirement);
            });
            let requirementsTable = document.getElementById("functional-requirements");
            requirements.forEach((requirement) => {
                let requirementRow = document.createElement("tr");
                let number = document.createElement("td");
                let name = document.createElement("td");
                let priority = document.createElement("td");
                let layer = document.createElement("td");
                let story = document.createElement("td");
                let description = document.createElement("td");
                let tags = document.createElement("td");
                let type = document.createElement("type");

                number.innerHTML = requirement.number;
                name.innerHTML = requirement.name;
                priority.innerHTML = requirement.priority;
                layer.innerHTML = requirement.layer;
                story.innerHTML = requirement.story;
                description.innerHTML = requirement.description;
                tags.innerHTML = requirement.tags;
                type.innerHTML = requirement.type;

                requirementRow.appendChild(number);
                requirementRow.appendChild(name);
                requirementRow.appendChild(priority);
                requirementRow.appendChild(layer);
                requirementRow.appendChild(story);
                requirementRow.appendChild(description);
                requirementRow.appendChild(tags);
                requirementRow.appendChild(type);

                requirementsTable.appendChild(requirementRow);
            });


        });

}

function addRequirements() {
    document.getElementById("reqModal").style.display = "block";
}

function closeModal() {
    document.getElementById("form-container").reset();
    document.getElementById("reqModal").style.display = "none";
}