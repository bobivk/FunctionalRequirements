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

signUpBtn.addEventListener('click', (event) => {
    if (signUpBtn.classList.contains("disable")) {
        //if clicked while disabled, enable
        nameField.style.maxHeight = "60px";
        title.innerHTML = "Регистрация";
        signUpBtn.classList.remove("disable");
        signInBtn.classList.add("disable");
        getAndEnableAllPasswordChecks();
        return;
    }
    //if enabled, try register
    const data = {};
    const fields = document.querySelectorAll('input');
    fields.forEach(field => {
        data[field.name] = field.value;
    });

    if (isEmailValid(data.email) && !userExists(data)) {
        fetch('http://localhost/FunctionalRequirements/backend/api/users/register-user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then((response) => {
                // location.reload();
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

    if (len <= 10 && input != "") {
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

function userExists(data) {
    fetch('http://localhost/FunctionalRequirements/backend/api/users/user-exists.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then((res) => {
            return res.json();
        })
        .then((resultJson) => {
            if (resultJson["exists"]) {
                if (resultJson["sameUsername"]) {
                    document.getElementById('username-exists-error').innerHTML = "Потребител с име '" + username + "' вече съществува.";
                    document.getElementById('username-exists-error').style.display = "block";
                }
                if (resultJson["sameEmail"]) {
                    document.getElementById('email-exists-error').innerHTML = "Потребител с имейл адрес '" + email + " вече съществува.";
                    document.getElementById('email-exists-error').style.display = "block";
                }
                return true;
            }
            document.getElementById('username-exists-error').style.display = "none";
            document.getElementById('email-exists-error').style.display = "none";
            return false;
        });
}


signInBtn.addEventListener('click', (event) => {
    if (signInBtn.classList.contains("disable")) {
        //if clicked while disabled, enable
        nameField.style.maxHeight = "0";
        title.innerHTML = "Вход";
        signUpBtn.classList.add("disable");
        signInBtn.classList.remove("disable");
        getAndDisableAllPasswordChecks();
        return;
    }
    const data = {};
    const fields = document.querySelectorAll('input');

    fields.forEach(field => {
        data[field.name] = field.value;
    });

    fetch("http://localhost/FunctionalRequirements/backend/api/login.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            location = 'http://localhost/FunctionalRequirements/frontend/html/homepage.html';
        });

    event.preventDefault();
});