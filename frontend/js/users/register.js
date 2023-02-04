const signUpBtn = document.getElementById("signUpBtn");
const signInBtn = document.getElementById("signInBtn");
const nameField = document.getElementById("nameField");
const title = document.getElementById("title");

function getAndDisableAllPasswordChecks() {
    const check0 = document.getElementById("check0");
    const check1 = document.getElementById("check1");
    const check2 = document.getElementById("check2");
    const check3 = document.getElementById("check3");
    const check4 = document.getElementById("check4");

    check0.style.display = "none";
    check1.style.display = "none";
    check2.style.display = "none";
    check3.style.display = "none";
    check4.style.display = "none";
}

function getAndEnableAllPasswordChecks() {
    const check0 = document.getElementById("check0");
    const check1 = document.getElementById("check1");
    const check2 = document.getElementById("check2");
    const check3 = document.getElementById("check3");
    const check4 = document.getElementById("check4");

    check0.style.display = "block";
    check1.style.display = "block";
    check2.style.display = "block";
    check3.style.display = "block";
    check4.style.display = "block";
}

signInBtn.onclick = function() {
    nameField.style.maxHeight = "0";
    title.innerHTML = "Вход";
    signUpBtn.classList.add("disable");
    signInBtn.classList.remove("disable");
    getAndDisableAllPasswordChecks();
}

signUpBtn.onclick = function() {
    nameField.style.maxHeight = "60px";
    title.innerHTML = "Регистрация";
    signUpBtn.classList.remove("disable");
    signInBtn.classList.add("disable");
    getAndEnableAllPasswordChecks();
}

signUpBtn.addEventListener('click', (event) => {
    debugger;

    const data = {};
    const fields = document.querySelectorAll('input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });

    if (isEmailValid(data.email) && !userExists(data.username, data.email)) {
        fetch('../backend/api/users/register-user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then((response) => {
                location = "../frontend/html/login.html";
            })
    }

    event.preventDefault();
});

function isEmailValid(email) {
    if (email == null || email == "" || !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}/.test(email)) {
        document.getElementById('email-error').innerHTML = "Моля, въведете валиден имейл адрес.";
        document.getElementById('email-error').style.display = "block";
        return false;
    }
    document.getElementById('email-error').style.display = "none";
    return true;
}

function checkPassword() {
    var input = document.getElementById("password").value;

    input = input.trim(); //removes all whitespaces
    document.getElementById("password").value = input;

    var len = input.length;
    if (len >= 6) {
        document.getElementById("check0").style.color = "green";
    } else {
        document.getElementById("check0").style.color = "#555";
    }

    if (len <= 10) {
        document.getElementById("check1").style.color = "green";
    } else {
        document.getElementById("check1").style.color = "#555";
    }

    if (input.match(/[0-9]/i)) {
        document.getElementById("check4").style.color = "green";
    } else {
        document.getElementById("check4").style.color = "#555";
    }

    if (input.match(/[A-Z]/)) {
        document.getElementById("check3").style.color = "green";
    } else {
        document.getElementById("check3").style.color = "#555";
    }

    if (input.match(/[a-z]/)) {
        document.getElementById("check2").style.color = "green";
    } else {
        document.getElementById("check2").style.color = "#555";
    }

}

function userExists(username, email) {
    fetch('../../../../backend/api/users/get-users.php')
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            exists = false;
            data.forEach(user => {
                if (user.username === username) {
                    document.getElementById('username-exists-error').innerHTML = "Потребител с име '" + username + "' вече съществува.";
                    document.getElementById('username-exists-error').style.display = "block";
                    exists = true;
                }
                if (user.email === email) {
                    document.getElementById('email-exists-error').innerHTML = "Потребител с имейл адрес '" + email + " вече съществува.";
                    document.getElementById('email-exists-error').style.display = "block";
                    exists = true;
                }
            })
            if (!exists) {
                document.getElementById('username-exists-error').style.display = "none";
                document.getElementById('email-exists-error').style.display = "none";
            }
            return exists;
        });
}


signInBtn.addEventListener('click', (event) => {

    if (!signInBtn.classList.contains("disable")) {
        const data = {};
        const fields = document.querySelectorAll('input');

        fields.forEach(field => {
            data[field.name] = field.value;
        });

        fetch("../../backend/api/login.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                location = '../../../html/projects.html';
            });

        event.preventDefault();
    }
});