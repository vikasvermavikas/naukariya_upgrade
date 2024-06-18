<!DOCTYPE html>
<html>

<head>
    <title>Mail</title>
    <meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css style -->
    <style type="text/css">
        .container {
            width: 800px;
            margin: auto;
        }

        footer ul li {
            list-style: none;

        }

        footer ul {
            padding: 0;
        }

        body {
            font-family: system-ui;
            font-size: 15px;
        }

        footer {
            background-color: #010027;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        footer a {
            color: #fff;
        }

        nav img {
            width: 260px;
            margin-bottom: .5rem;
        }

    </style>
</head>

<body>
    <nav>
        <center>
            <img class="responsive" src="https://naukriyan.com/default_images/logo.png" alt="Naukriyan">
        </center>
    </nav>
    <div class="container">
        <strong>Dear {{ $fname }},</strong><br>
        <p>Your Account was Created Successfully.Please Login with below Credential-</p>

        <ul>
            <li>Username/Email - {{ $email }} </li>
            <li>Password - {{ $password }}</li>
            <li>URL - <a href="https://naukriyan.com/#/subuser-login"> Click Here</a> </li>
        </ul>
        <p>For any issues related to the system you can send us an email at <a
                href="mailto:info@naukriyan.com">info@naukriyan.com</a>

            <br><br>
            Thanks & Regards,<br>
            <b>Team Naukriyan</b>
        </p>
        <footer>
            <ul>
                <li>Website : <a href="https://naukriyan.com/"> www.naukriyan.com</a></li>
                <li>Email :<a href="mailto:info@naukriyan.com"> info@naukriyan.com</a></li>
                <li>Contact :<a href="tel:+91-1179626411"> +91-1179626411</a></li>
            </ul>
        </footer>
    </div>


</body>

</html>
