import { Project } from '../projects.js';

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