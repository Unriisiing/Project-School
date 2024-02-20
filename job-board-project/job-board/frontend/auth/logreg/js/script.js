document.addEventListener("DOMContentLoaded", function () {
    var role = document.getElementById('role');
    var screenElement = document.getElementById('screenid');
    var registerForm = document.getElementById('signupform');
    var loginButton = document.querySelector('.loginS');

    role.addEventListener('change', function() {
        if (role.value === 'advertiser') {
            screenElement.style.width = '600px';
            registerForm.style.width = '600px';
            screenElement.style.height = '800px';
            registerForm.style.height = '800px';
        } else {
            screenElement.style.width = '360px';
            registerForm.style.width = '320px';
            screenElement.style.height = '600px';
            registerForm.style.height = '600px';
        }
    });

    loginButton.addEventListener('click', function() {
        screenElement.style.width = '360px';
        registerForm.style.width = '320px';
        screenElement.style.height = '600px';
        registerForm.style.height = '';
    });
});

function toggleCompanyRegistration() {
    var roleSelect = document.getElementById("role");
    var companyFields = document.querySelectorAll(".company-field");
    var companyRegistration = document.getElementById("companyRegistration");

    if (roleSelect.value === "advertiser") {
        // Show the company registration fields
        companyRegistration.style.display = "block";

        // Add "required" attribute to company fields
        companyFields.forEach(function(field) {
            field.setAttribute("required", "required");
        });


    } else {
        // Hide the company registration fields
        companyRegistration.style.display = "none";

        // Remove "required" attribute from company fields
        companyFields.forEach(function(field) {
            field.removeAttribute("required");
        });
    }
}
   

    










