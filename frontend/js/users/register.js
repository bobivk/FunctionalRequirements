const registrationForm = document.getElementById('registration-form');
registrationForm.addEventListener('submit', (event) => {
    const data = {};
    const fields = registrationForm.querySelectorAll('input');
    fields.foreach(field => {
        data[field.name] = field.value;
    });

    if (!userExists(data.username, data.email)) {
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

    event.preventDefault(); //do not refresh page
});

function isEmailValid(email) {
    if (email == null || email == "" || !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
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
        document.getElementById("check0").style.color = "red";
    }

    if (len <= 10) {
        document.getElementById("check1").style.color = "green";
    } else {
        document.getElementById("check1").style.color = "red";
    }

    if (input.match(/[0-9]/i)) {
        document.getElementById("check4").style.color = "green";
    } else {
        document.getElementById("check4").style.color = "red";
    }

    if (input.match(/[A-Z]/)) {
        document.getElementById("check3").style.color = "green";
    } else {
        document.getElementById("check3").style.color = "red";
    }

    if (input.match(/[a-z]/)) {
        document.getElementById("check2").style.color = "green";
    } else {
        document.getElementById("check2").style.color = "red";
    }

}

function areSamePasswords() {
    var pass = document.getElementById("password").value;
    var repeatPass = document.getElementById("reEnterPassword").value;

    if (pass === repeatPass) {
        document.getElementById("checkSamePassword").style.color = "green";
    } else {
        document.getElementById("checkSamePassword").style.color = "red";
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
                    document.getElementById('username-error').innerHTML = "Потребител с име '" + username + "' вече съществува.";
                    document.getElementById('username-error').style.display = "block";
                    exists = true;
                }
                if (user.email === email) {
                    document.getElementById('email-error').innerHTML = "Потребител с имейл адрес '" + email + " вече съществува.";
                    document.getElementById('email-error').style.display = "block";
                    exists = true;
                }
            })
            if (!exists) {
                document.getElementById('username-error').style.display = "none";
                document.getElementById('email-error').style.display = "none";
            }
            return exists;
        });
}