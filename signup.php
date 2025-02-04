<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Purple to Blue Gradient */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            padding: 40px;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: scale(1.02);
        }

        header {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .step {
            position: relative;
            text-align: center;
            flex: 1;
        }

        .step p {
            font-size: 16px;
            margin: 5px 0;
            color: #666;
        }

        .bullet {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #2575fc;
            color: white;
            font-weight: bold;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .check {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
        }

        .form-outer {
            padding-top: 20px;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        .field {
            margin-bottom: 20px;
        }

        .label {
            font-size: 18px; /* Larger font size */
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="file"],
        input[type="radio"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
            background-color: #f4f4f4;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        input[type="file"]:focus,
        input[type="date"]:focus {
            border-color: #2575fc;
        }

        .gender-options {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .gender-options input[type="radio"] {
            width: 20px;
            height: 20px;
        }

        .gender-options label {
            font-size: 18px; /* Larger font size for gender labels */
            font-weight: normal;
            color: #333;
        }

        .btns {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #1a66cc;
            transform: translateY(-2px);
        }

        .prev,
        .next {
            background-color: #6a11cb;
            color: white;
        }

        .prev:hover,
        .next:hover {
            background-color: #520fa6;
        }

        .submit {
            background-color: #2575fc;
            color: white;
        }

        .submit:hover {
            background-color: #1a66cc;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link a {
            color: #2575fc;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>Sign Up</header>
        <?php
            if(isset($_SESSION['status'])) {
                echo $_SESSION['status'];
                unset($_SESSION['status']);
            }
        ?>
        <div class="progress-bar">
            <div class="step">
                <p>Name</p>
                <div class="bullet"><span>1</span></div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Contact</p>
                <div class="bullet"><span>2</span></div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Birth</p>
                <div class="bullet"><span>3</span></div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Submit</p>
                <div class="bullet"><span>4</span></div>
                <div class="check fas fa-check"></div>
            </div>
        </div>
        <div class="form-outer">
            <form action="http://localhost/obss/php/insertsignup.php" method="POST" enctype="multipart/form-data" id="signupForm">
                <!-- First Page: Basic Info -->
                <div class="page active">
                    <div class="title">Basic Info:</div>
                    <div class="field">
                        <div class="label">First Name</div>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>
                    <div class="field">
                        <div class="label">Last Name</div>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                    <div class="field">
                        <button type="button" class="next">Next</button>
                    </div>
                    <!-- Back Button to Login Page -->
                    <div class="field">
                        <a href="userlogin.php" class="prev">Back to Login</a>
                    </div>
                </div>

                <!-- Second Page: Contact Info -->
                <div class="page">
                    <div class="title">Contact Info:</div>
                    <div class="field">
                        <div class="label">Email Address</div>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="field">
                        <div class="label">Phone Number</div>
                        <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}">
                    </div>
                    <div class="field btns">
                        <button type="button" class="prev">Previous</button>
                        <button type="button" class="next">Next</button>
                    </div>
                </div>

                <!-- Third Page: Date of Birth -->
                <div class="page">
                    <div class="title">Date of Birth:</div>
                    <div class="field">
                        <div class="label">Date</div>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="field gender-options">
                        <label for="m">Male</label>
                        <input type="radio" id="m" name="sex" value="m">
                        <label for="f">Female</label>
                        <input type="radio" id="f" name="sex" value="f">
                        <label for="o">Other</label>
                        <input type="radio" id="o" name="sex" value="o">
                    </div>
                    <div class="field btns">
                        <button type="button" class="prev">Previous</button>
                        <button type="button" class="next">Next</button>
                    </div>
                </div>

                <!-- Fourth Page: Login Details -->
                <div class="page">
                    <div class="title">Login Details:</div>
                    <div class="field">
                        <div class="label">Image</div>
                        <input type="file" name="uploadfile" id="image" required>
                    </div>
                    <div class="field">
                        <div class="label">Username</div>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="field">
                        <div class="label">Password</div>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="field btns">
                        <button type="button" class="prev">Previous</button>
                        <button type="submit" class="submit" name="submit" id="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add JavaScript to handle page transitions and validations
        const pages = document.querySelectorAll('.page');
        const nextButtons = document.querySelectorAll('.next');
        const prevButtons = document.querySelectorAll('.prev');
        
        nextButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                if (validatePage(index)) {
                    pages[index].classList.remove('active');
                    pages[index + 1].classList.add('active');
                }
            });
        });

        prevButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                pages[index + 1].classList.remove('active');
                pages[index].classList.add('active');
            });
        });

        function validatePage(index) {
            let valid = true;
            const currentPage = pages[index];
            const inputs = currentPage.querySelectorAll('input');
            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value) {
                    valid = false;
                    alert('Please fill in all required fields');
                }
            });

            // Validate email for @gmail.com
            const email = document.getElementById('email').value;
            if (email && !email.includes('@gmail.com')) {
                valid = false;
                alert('Email must be a Gmail address');
            }

            // Validate phone number for 10 digits
            const phone = document.getElementById('phone').value;
            if (phone && phone.length !== 10) {
                valid = false;
                alert('Phone number must be exactly 10 digits');
            }

            // Validate password for required criteria
            const password = document.getElementById('password').value;
            const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
            if (password && !passwordRegex.test(password)) {
                valid = false;
                alert('Password must be 8 characters long, contain at least one uppercase letter, one special character, and one digit');
            }

            return valid;
        }
    </script>
</body>
</html>
