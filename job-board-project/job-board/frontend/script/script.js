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

function toggleContent(adId) {
    var content = document.getElementById('content-' + adId);
    if (content.style.display === "none") {
        content.style.display = "block";
    } else {
        content.style.display = "none";
    }
}

function confirmDelete(adId) {
    var confirmDelete = confirm("Are you sure you want to delete this advertisement?");
    if (confirmDelete) {
        window.location.href = '../../backend/advertiser/crud/deleteAd.php?ad_id=' + adId;
    }
}

function confirmApply() {
    return confirm("Are you sure you want to apply?");
}




function displayApplyPopup(adId) {
    const popup = document.getElementById('apply-popup');
    const applyFormContainer = document.getElementById('applyFormContainer');
    applyFormContainer.innerHTML = `
        <form method="post" action="../../backend/applicantNotLogged/apply/apply.php">
            <input type="hidden" name="ad_id" value="${adId}">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" required><br>
            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="cv_file">Upload CV:</label><br>
            <input type="file" id="cv_file" name="cv_file"><br>
            <label for="message">Un petit message?</label><br>
            <input type="message" id="message" name="message"><br><br>
            <input type="submit" value="Submit">
        </form>
    `;
    popup.style.display = 'block';
}

    
// JavaScript pour masquer la popup lorsqu'on clique en dehors du formulaire
document.addEventListener('click', function(event) {
    const popupTout = document.querySelector('.popup-tout');
    const popup = document.getElementById('apply-popup');

    if (event.target === popupTout) {
        popup.style.display = 'none';
    }
});


