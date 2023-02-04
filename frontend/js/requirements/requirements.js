import { Project } from '../projects.js';

export class Requirement {
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

let projectDiv = document.getElementById("project");

let project = fetch("../../../backend/api/projects/get-project.php" //+ new URLSearchParams({
        //  "id":
        //})
    )
    .then((response) => {
        return response.json();
    })
    .then((projectJson) => {
        return new Project(projectJson.name, projectJson.number, projectJson.description);
    });
let projectName = document.createElement("h2");
projectName.innerHTML = "Проект номер " + project.number + ". " + project.name + ".";
let projectDesc = document.createElement("p");
projectDesc.innerHTML = project.description;
projectDiv.appendChild(projectDesc);

let requirements = fetch("../../../backend/api/requirements/get-requirements.php" //+ new URLSearchParams project_id
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



const requirementForm = document.getElementById('requirement-form');
requirementForm.addEventListener('submit', (event) => {
    const data = {};
    const fields = requirementForm.querySelectorAll('input');
    fields.foreach(field => {
        data[field.name] = field.value;
    });

    fetch('../backend/api/users/save-requirement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then((response) => {
            //show successfully added message
        })


    event.preventDefault(); //do not refresh page
});