export class Project {
    constructor(id, name, number, description) {
        this.id = id;
        this.name = name;
        this.number = number;
        this.description = description
    }
}

let projectsDiv = document.getElementById("projects");

let projects = fetch("../../../backend/api/projects/get-projects.php")
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        let projects = [];
        data.forEach(projectJson => {
            let project = new Project(projectJson.id, projectJson.name, projectJson.number, projectJson.description);
            projects.push(project);
        })
        return projects;
    });
let projectsUl = document.createElement("ul");

for (i = 0; i < projects.length; i++) {
    let projectItem = document.createElement("li");
    projectItem.innerHTML = projects[i].number + ". " + projects[i].name;
    attachListener(projectItem);
    projectsUl.appendChild(projectItem);
}

projectsDiv.appendChild(projectsUl);

function attachListener(item) {
    item.addEventListener('click', event => {
        //window.open(''); open page of this project with its id
    });
}

$(document).ready(function () {
    $(document.body).on("click", "tr[data-href]", function (){
        window.location.href = this.dataset.href;
    });
});