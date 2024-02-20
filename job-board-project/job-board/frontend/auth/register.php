<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../frontend/script/script.js"></script> 
    <title>Register</title>
</head>
<body>
<h1>Register</h1>

<form action="../../backend/auth/register.php" method="post" enctype="multipart/form-data">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="role">Role:</label>
    <select id="role" name="role" required onchange="toggleCompanyRegistration()">
        <option value="applicant">Applicant</option>
        <option value="advertiser">Advertiser</option>
    </select><br>

    <!-- Add class="company-field" to the company fields -->
    <div id="companyRegistration" style="display:none;">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" class="company-field"><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" class="company-field"><br>

        <label for="contact_email">Contact Email:</label>
        <input type="email" id="contact_email" name="contact_email" class="company-field"><br>
    </div>

    <label for="profile_img">Profile Image (optional):</label>
    <input type="file" id="profile_img" name="profile_img"><br>

    <input type="submit" value="Register">
</form>
</body>
</html>