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