class Requirement {
    constructor(id, name, projectId, priority, layer, story, number, description, tags) {
        this.id = id;
        this.name = name;
        this.projectId = projectId;
        this.priority = priority;
        this.layer = layer;
        this.story = story
        this.number = number;
        this.description = description;
        this.tags = tags;
    }
}
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

let project = fetch("http://localhost/FunctionalRequirements/backend/api/projects/get-project.php?id=" + params.id)
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

if (isAdmin()) {
    document.getElementById("edit-project").style.display = "block";
    document.getElementById("delete-project").style.display = "block";
    document.getElementById("save-project").style.display = "block";
    //for each requirement row display edit/delete buttons
}

async function isAdmin() {
    const response = await fetch("http://localhost/FunctionalRequirements/backend/api/users/is-admin.php");
    const data = await response.json();
    return data["isAdmin"];
}

fetchRequirements();

const requirementForm = document.getElementById('requirement-form');
requirementForm.addEventListener('submit', (event) => {
    const data = {};
    const fields = requirementForm.querySelectorAll('input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });

    fetch('http://localhost/FunctionalRequirements/backend/api/requirements/save-requirement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then((response) => {
            console.log(response.json());
        });
    event.preventDefault();
});

const deleteProjectButton = document.getElementById("delete-project");
deleteProjectButton.addEventListener('click', (event) => {

    fetch('http://localhost/FunctionalRequirements/backend/delete-project.php&id=' + project.id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => {
            if (response.status == 403) {
                alert("Нужни са администраторски права за изтриване на този проект.");
                //document.getElementById("admin-required-error").style.display = "block"
            } else {
                location = '../../../html/projects.html';
            }
        });
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
//same for delete requirement when we have the buttons.

const addRequirementButton = document.getElementById("add-requirement-btn");
addRequirementButton.addEventListener('click', (event) => {
    let requirementInput = document.querySelectorAll("requirement-input");
    fetch('http://localhost/FunctionalRequirements/backend/requirements/save-requirement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: json.stringify(requirementInput)
        })
        .then((response) => {
            console.log(response.json());
            fetchRequirements();
        })
})

function fetchRequirements() {
    let requirements = fetch("http://localhost/FunctionalRequirements/backend/api/requirements/get-requirements.php" //+ new URLSearchParams project_id
        )
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            let requirements = [];
            data.forEach((req) => {
                let requirement = new Requirement(req.id, req.name, req.project_id, req.priority, req.layer, req.story, req.description, req.tags);
                requirements.push(requirement);
            })
            return requirements;
        });

    let requirementsTable = document.getElementById("functional-requirements");
    requirements.forEach((requirement) => {
        let requirementRow = document.createElement("tr");
        let name = document.createElement("td");
        let priority = document.createElement("td");
        let layer = document.createElement("td");
        let story = document.createElement("td");
        let description = document.createElement("td");
        let tags = document.createElement("td");

        name.innerHTML = requirement.name;
        priority.innerHTML = requirement.priority;
        layer.innerHTML = requirement.layer;
        story.innerHTML = requirement.story;
        description.innerHTML = requirement.description;
        tags.innerHTML = requirement.tags;

        requirementRow.appendChild(name);
        requirementRow.appendChild(priority);
        requirementRow.appendChild(layer);
        requirementRow.appendChild(story);
        requirementRow.appendChild(description);
        requirementRow.appendChild(tags);

        requirementsTable.appendChild(requirementRow);
    });

}