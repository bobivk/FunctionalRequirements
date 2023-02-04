const registrationForm = document.getElementById('registration-form');
registrationForm.addEventListener('submit', (event) => {
    const data = {};
    const fields = registrationForm.querySelectorAll('input');
    fields.foreach(field => {
        data[field.name] = field.value;
    });

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

    event.preventDefault(); //do not refresh page
});