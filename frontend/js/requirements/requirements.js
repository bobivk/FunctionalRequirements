class Requirement {
    constructor(id, name, projectId, priority, layer, story, description, tags, type) {
        this.id = id;
        this.name = name;
        this.projectId = projectId;
        this.priority = priority;
        this.layer = layer;
        this.story = story
        this.description = description;
        this.tags = tags;
        this.type = type;
    }
}
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
let project = {};

fetch("http://localhost/FunctionalRequirements/backend/api/projects/get-project.php?projectId=" + params.projectId)
    .then((response) => {
        return response.json();
    })
    .then((projectJson) => {
        project = new Project(projectJson.id, projectJson.name, projectJson.number, projectJson.description, projectJson.status);
        let projectName = document.getElementById("project-name");
        projectName.innerHTML = project.number + ". " + project.name;
        let projectDesc = document.getElementById("project-description");
        projectDesc.innerHTML = project.description;
        let projectStatus = document.getElementById("project-status");

        const projectStatusColor = document.createElement("span");
        projectStatusColor.classList.add("status");
        if (project.status == "незапочнат") {
            projectStatusColor.classList.add("grey");
        } else if (project.status == "чернова") {
            projectStatusColor.classList.add("purple");
        } else {
            projectStatusColor.classList.add("light-purple");
        }
        projectStatus.appendChild(projectStatusColor);
        projectStatus.innerHTML += project.status;
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
            closeRequirementsModal();
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

const saveProjectButton = document.getElementById("save-project-btn");
saveProjectButton.addEventListener('click', (event) => {
    const data = {};
    const fields = document.querySelectorAll('.project-input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });
    data["projectId"] = params.projectId;
    fetch('http://localhost/FunctionalRequirements/backend/api/projects/update-project.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then((response) => {
            if (response.status == 403) {
                alert("Нужни са администраторски права за промяна на този проект");
            }
            else if (response.status == 200) {
                location.reload();
            }
        });

    event.preventDefault();
});
let allRequirements = [];

function fetchRequirements() {
    fetch("http://localhost/FunctionalRequirements/backend/api/requirements/get-requirements.php?projectId=" + params.projectId)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            let requirements = [];
            data.forEach((req) => {
                let requirement = new Requirement(req.id, req.name, req.project_id, req.priority, req.layer, req.story, req.description, req.tags, req.type);
                requirements.push(requirement);
                allRequirements.push(requirement);
            });
            fillTable(requirements);
        });

}

function openRequirementsModal() {
    document.getElementById("req-modal").style.display = "block";
}

function openEditRequirementsModal(requirementId) {
    document.getElementById("edit-req-modal").style.display = "block";
    document.getElementById("edit-req-modal").setAttribute("requirement-id", requirementId);
}

function closeEditRequirementsModal() {
    document.getElementById("form-container").reset();
    document.getElementById("edit-req-modal").style.display = "none";
}

function openProjectModal() {
    document.getElementById("project-modal").style.display = "block";
    const name = document.getElementById("project-name").innerText.split(".");
    document.getElementById("project-input-number").value = name[0];
    document.getElementById("project-input-name").value = name[1];
    document.getElementById("project-input-description").value = document.getElementById("project-description").innerText;
}

function closeRequirementsModal() {
    document.getElementById("form-container").reset();
    document.getElementById("req-modal").style.display = "none";
}

function closeProjectModal() {
    document.getElementById("form-container").reset();
    document.getElementById("project-modal").style.display = "none";
}

function inEditMode() {
    document.getElementById("edit-project").style.display = "none";
    document.getElementById("delete-project").style.display = "none";
    document.getElementById("save-project").style.display = "inline-block";
    document.getElementById("close-edit-project").style.display = "inline-block";
}

function notInEditMode() {
    document.getElementById("edit-project").style.display = "inline-block";
    document.getElementById("delete-project").style.display = "inline-block";
    document.getElementById("save-project").style.display = "none";
    document.getElementById("close-edit-project").style.display = "none";
}

function attachDeleteRequirementListener(deleteRequirementButton, id) {
    deleteRequirementButton.addEventListener('click' , (event) => {
        fetch("http://localhost/FunctionalRequirements/backend/api/requirements/delete-requirement.php?id=" + id)
        .then((response) => {
            if(response.status == 201) {
                document.getElementById("req-deleted-msg").style.display = "block";
                let requirementRow = document.getElementById("requirement-"+id);
                requirementRow.parentElement.removeChild(requirementRow);
                setTimeout(() => {
                    document.getElementById("req-deleted-msg").style.display = "none";
                }, "3000");
            }
            else alert("Could not delete requirement.");
        })
    })
}


function logout() {
    location = "http://localhost/FunctionalRequirements/frontend/html/register.html";
}

window.addEventListener("load", () => {
    document.querySelectorAll(".table-sort-btn")
    .forEach((button) => {
      button.addEventListener("click", (e) => {
        resetButtons(e);
        if (e.target.getAttribute("data-dir") == "desc") {
          sortData(allRequirements, e.target.id.split("-")[1], "desc");
          e.target.setAttribute("data-dir", "asc");
        } else {
          sortData(allRequirements, e.target.id.split("-")[1], "asc");
          e.target.setAttribute("data-dir", "desc");
        }
        
      });
    });
  });

  const resetButtons = (event) => {
    document.querySelectorAll(".table-sort-btn")
    .forEach((button) => {
      if (button !== event.target) {
        button.removeAttribute("data-dir");
      }
    });
  };

  const sortData = (data, param, direction = "asc") => {
    const sortedData =
      direction == "asc"
        ? [...data].sort(function (a, b) {
            if (a[param] < b[param]) {
              return -1;
            }
            if (a[param] > b[param]) {
              return 1;
            }
            return 0;
          })
        : [...data].sort(function (a, b) {
            if (b[param] < a[param]) {
              return -1;
            }
            if (b[param] > a[param]) {
              return 1;
            }
            return 0;
          });
    fillTable(sortedData);
  };

  const fillTable = (requirements) => {
    document.getElementById("requirements-table-body").innerHTML = '';
    requirements.forEach((requirement) => {
        let requirementRow = document.createElement("tr");
        requirementRow.id = "requirement-" + requirement.id;

        let name = document.createElement("td");
        let priority = document.createElement("td");
        let layer = document.createElement("td");
        let story = document.createElement("td");
        let description = document.createElement("td");
        let tags = document.createElement("td");
        let type = document.createElement("td");
        let action = document.createElement("td");

        let btns = document.createElement("div");
        btns.id = "action-btns";
        let editBtn = document.createElement("button");
        editBtn.id = "edit-requirement-" + requirement.id;
        editBtn.classList.add("edit-requirement-btn");
        let deleteBtn = document.createElement("button");
        deleteBtn.id = "delete-requirement" + requirement.id;
        deleteBtn.classList.add("delete-requirement-btn");
      
        let iconEdit = document.createElement("i");
        iconEdit.classList.add("las");
        iconEdit.classList.add("la-edit");
        let iconDelete = document.createElement("i");
        iconDelete.classList.add("las");
        iconDelete.classList.add("la-trash-alt");
        
        attachEditRequirementListener(editBtn, requirement);
        attachDeleteRequirementListener(deleteBtn, requirement.id);

        editBtn.appendChild(iconEdit);
        deleteBtn.appendChild(iconDelete);
        btns.appendChild(editBtn);
        btns.appendChild(deleteBtn);
        action.appendChild(btns);


        name.innerHTML = requirement.name;
        priority.innerHTML = requirement.priority;
        layer.innerHTML = requirement.layer;
        story.innerHTML = requirement.story;
        description.innerHTML = requirement.description;
        tags.innerHTML = requirement.tags;
        type.innerHTML = requirement.type;

        requirementRow.appendChild(name);
        requirementRow.appendChild(priority);
        requirementRow.appendChild(layer);
        requirementRow.appendChild(story);
        requirementRow.appendChild(description);
        requirementRow.appendChild(tags);
        requirementRow.appendChild(type);
        requirementRow.appendChild(action);


        document.getElementById("requirements-table-body").appendChild(requirementRow);
    });
  };

//export
const requirementsTable = document.getElementById("functional-requirements");
const btnExportToCsv = document.getElementById("export-requirements-btn");

btnExportToCsv.addEventListener("click", () => {
    const exporter = new TableCSVExporter(requirementsTable);
    const csvOutput = exporter.convertToCSV();
    const csvBlob = new Blob([csvOutput], { type: "text/csv" });
    const blobUrl = URL.createObjectURL(csvBlob);
    const anchorElement = document.createElement("a")
    anchorElement.href = blobUrl;
    anchorElement.download = "requirements_" + project.number + ".csv";
    anchorElement.click()
    setTimeout(() => {
        URL.revokeObjectURL(blobUrl);
    }, 500);
});



function attachEditRequirementListener(editRequirementButton, requirement) {
    //fill in input from requirement object
    editRequirementButton.addEventListener('click', (event) => {
        const nameInput = document.getElementById("edit-req-name");
        nameInput.value = requirement.name;
        const typeInput = document.getElementById("edit-req-type");
        typeInput.options[typeInput.value.selectedIndex] = requirement.type;
        typeInput.value = requirement.type;
        const priorityInput = document.getElementById("edit-req-priority");
        priorityInput.options[priorityInput.value.selectedIndex] = requirement.priority;
        priorityInput.value = requirement.priority;
        const layerInput = document.getElementById("edit-req-layer");
        layerInput.value = requirement.layer;
        const descriptionInput = document.getElementById("edit-req-description");
        descriptionInput.value = requirement.description;
        const storyInput = document.getElementById("edit-req-story");
        storyInput.value = requirement.story;
        const tagsInput = document.getElementById("edit-req-tags");
        tagsInput.value = requirement.tags;
        openEditRequirementsModal(requirement.id);
    });
    
}

const editSaveRequirementButton = document.getElementById("edit-save-requirement-btn")
editSaveRequirementButton.addEventListener('click' , (event) => {
    event.preventDefault();
    const data = {};
    const fields = document.querySelectorAll('.requirement-edit-input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });
    data["requirementId"] = document.getElementById("edit-req-modal").getAttribute("requirement-id");
    fetch("http://localhost/FunctionalRequirements/backend/api/requirements/update-requirement.php", {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then((response) => {
        if(response.status == 200) {
            location.reload();
        }
        //handle error status codes
    });
})