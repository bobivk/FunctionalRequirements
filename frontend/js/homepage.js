function openProjectForm() {
    document.getElementById("modal").style.display = "block";
}

function closeForm() {
    document.getElementById("project-form").reset();
    document.getElementById("modal").style.display = "none";
}


function openImportModal() {
    document.getElementById("modal-import-project").style.display = "block";
}

function closeImportModal() {
    document.getElementById("import-form").reset();
    document.getElementById("modal-import-project").style.display = "none";
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
    fetch("../../backend/api/projects/save-project.php", {
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

fetch("../../backend/api/projects/get-projects.php")
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

            const projectDescriptionTd = document.createElement("td");
            projectDescriptionTd.innerHTML = project.description;
            projectRow.appendChild(projectDescriptionTd);

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
        location.href = './requirements.php?projectId=' + projectId; //open page of this project with its id
    });
}



function fetchRequirementCount(type, element) {
    fetch("../../backend/api/requirements/get-requirements-count.php?type=" + type)
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
    location = "../../backend/logout.php";
}

//import projects
document.getElementById("import-form").addEventListener('submit', (event) => {
    const projectFile = document.getElementById("project-import-file").files[0];
    const formData = new FormData();
    formData.append('files[]', projectFile)
    fetch("../../backend/api/projects/import-projects.php", {
      method: 'POST',
      body: formData,
    }).then((response) => {
        if(response.status == 400) {
            alert("Файлът не е във валиден формат.");
        }
        if(response.status == 200) {
            document.getElementById("import-form").reset();
            location.reload();
        }
    });
    event.preventDefault();
});


//export projects
const projectsTable = document.getElementById("project-table-body");
const btnExportToCsv = document.getElementById("export-projects-btn");

btnExportToCsv.addEventListener("click", () => {
    const exporter = new TableCSVExporter(projectsTable);
    const csvOutput = exporter.convertToCSV();
    const csvBlob = new Blob([csvOutput], { type: "text/csv" });
    const blobUrl = URL.createObjectURL(csvBlob);
    const anchorElement = document.createElement("a")
    anchorElement.href = blobUrl;
    anchorElement.download = "projects.csv";
    anchorElement.click()
    setTimeout(() => {
        URL.revokeObjectURL(blobUrl);
    }, 500);
});

//search for project in projects table
(function(document) {
    'use strict';

    var TableFilter = (function(myArray) {
        var search_input;

        function _onInputSearch(e) {
            search_input = e.target;
            var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
            myArray.forEach.call(tables, function(table) {
                myArray.forEach.call(table.tBodies, function(tbody) {
                    myArray.forEach.call(tbody.rows, function(row) {
                        var text_content = row.textContent.toLowerCase();
                        var search_val = search_input.value.toLowerCase();
                        row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                    });
                });
            });
        }

        return {
            init: function() {
                var inputs = document.getElementsByClassName('search-input');
                myArray.forEach.call(inputs, function(input) {
                    input.oninput = _onInputSearch;
                });
            }
        };
    })(Array.prototype);

    document.addEventListener('readystatechange', function() {
        if (document.readyState === 'complete') {
            TableFilter.init();
        }
    });

})(document);


//resizable columns in table project-table
let table = document.getElementById('project-table');
resizableGrid(table);

function resizableGrid(table) {
    var row = table.getElementsByTagName('tr')[0],
    cols = row ? row.children : undefined;
    if (!cols) return;

for (var i=0;i<cols.length;i++){
    var div = createDiv(table.offsetHeight);
    cols[i].appendChild(div);
    cols[i].style.position = 'relative';
    setListeners(div);
   }
}

   function createDiv(height){
    var div = document.createElement('div');
    div.style.top = 0;
    div.style.right = 0;
    div.style.width = '2px';
    div.style.position = 'absolute';
    div.style.cursor = 'col-resize';
    div.style.backgroundColor = '#eaeaea';
    div.style.userSelect = 'none';
    div.style.height = height+'px';
    return div;
   }

function setListeners(div){
    var pageX,curCol,nxtCol,curColWidth,nxtColWidth;
    div.addEventListener('mousedown', function (e) {
     curCol = e.target.parentElement;
     nxtCol = curCol.nextElementSibling;
     pageX = e.pageX;
     curColWidth = curCol.offsetWidth
     if (nxtCol)
      nxtColWidth = nxtCol.offsetWidth
    });
   
    document.addEventListener('mousemove', function (e) {
     if (curCol) {
      var diffX = e.pageX - pageX;
    
      if (nxtCol)
       nxtCol.style.width = (nxtColWidth - (diffX))+'px';
   
      curCol.style.width = (curColWidth + diffX)+'px';
     }
    });
   
   document.addEventListener('mouseup', function (e) { 
    curCol = undefined;
    nxtCol = undefined;
    pageX = undefined;
    nxtColWidth = undefined;
    curColWidth = undefined;
    });
   }

   //add members in projects table last column
