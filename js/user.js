document.addEventListener("DOMContentLoaded", function () {
    // Your JavaScript code goes here

    // Example: Toggle active class on menu items
    const menuItems = document.querySelectorAll(".menu li");
    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            menuItems.forEach(i => i.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Example: Edit button click event
    const editButtons = document.querySelectorAll(".table--container button");
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Add your edit functionality here
            alert("Edit button clicked");
        });
    });
});
