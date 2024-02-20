function confirmDeleteAdvertiser(user_id) {
    var confirmed = confirm("Are you sure you want to delete?");
    if (confirmed) {
        window.location.href = '../../../backend/admin/delete/delete_advertiser.php?user_id=' + user_id;
    }
}
function confirmDeleteAdvertisement(ad_id) {
    var confirmed = confirm("Are you sure you want to delete?");
    if (confirmed) {
        window.location.href = '../../../backend/admin/delete/delete_advertisement.php?ad_id=' + ad_id;
    }
}

function confirmDeleteApplicant(user_id) {
    var confirmed = confirm("Are you sure you want to delete?");
    if (confirmed) {
        window.location.href = '../../../backend/admin/delete/delete_applicant.php?user_id=' + user_id;
    }
}

function confirmDeleteCompany(company_id) {
    var confirmed = confirm("Are you sure you want to delete?");
    if (confirmed) {
        window.location.href = '../../../backend/admin/delete/delete_company.php?company_id=' + company_id;
    }
}

