<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../FrontEnd/auth/logreg/style_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../../../frontend/auth/logreg/js/register.js"></script>
	<script src="../../../frontend/auth/logreg/js/script.js"></script>
    <title>Login / Register</title>
</head>
<body>

<div class="container">
    <div class="screen" id="screenid">
        <div class="screen__content">
            <div class="switch">
                <div class="loginS" onclick="switchLogin();">Login</div>
                <div class="signupS" onclick="switchSignup();">Signup</div>
            </div>
            <!-- Login Form -->
            <form class="login" id="loginForm" action="../../../backend/auth/login.php" method="post">
                <div class="login__field" id="page">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" class="login__input" name="email" placeholder="Email">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" class="login__input" name="password" placeholder="Password">
                </div>
                <button class="button login__submit">
                    <span class="button__text">Log In Now</span>
                </button>
            </form>

            <!-- Signup Form -->
            <form class="signup" id="signupform" action="../../../backend/auth/register.php" method="post" style="display: none;">
                <div class="login__field" id="page">
                    <i class="login__icon fas fa-envelope"></i>
                    <input type="text" class="login__input" name="first_name" placeholder="First Name">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" class="login__input" name="last_name" placeholder="Last Name">
                </div>
				<div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" class="login__input" name="email" placeholder="Email">
                </div>
				<div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" class="login__input" name="password" placeholder="password">
                </div>
				<div class="login__field">
                    <i class="login__icon fas fa-user"></i>
					<select id="role" name="role" class="login__input"  required onchange="toggleCompanyRegistration()" required onchange="changeStyle()">
       				 <option value="applicant" class="login__input">Applicant</option>
        			 <option value="advertiser"class="login__input">Advertiser</option>
    				</select><br>
                </div>
				<div id="companyRegistration" style="display:none;">
                    
					<input type="text" id="company_name" name="company_name" class="login__input" placeholder="Name of company"><br>

					<input type="text" id="address" name="address" class="login__input" placeholder="Address"><br>

					<input type="email" id="contact_email" name="contact_email" class="login__input" placeholder="Email Contact"><br>
    			</div>
    			<input type="file" id="profile_img" name="profile_img" class="login__input" placeholder="Image profile"><br>

				
                <button class="button signup__submit">
                    <span class="button__text">Sign up</span>
                </button>
            </form>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</div>

</body>
</html>