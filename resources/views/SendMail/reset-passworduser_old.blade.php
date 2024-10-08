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
            color: #404040;
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

        table,
        th,
        td {
            border: 1px solid #bfbfbf;
            border-collapse: collapse;
            padding: 4px 14px;

        }

        table {
            width: 100%;
        }

        tr,
        td {
            background-color: aliceblue;
        }

        tr,
        th {}

    </style>
</head>

<body>
    <nav>
        <center>
            <img class="responsive" src="https://naukriyan.com/default_images/logo%20naukriyan.png" alt="Naukriyan">
        </center>
    </nav>
    <div class="container">
        <strong>Dear User,</strong><br>
        <p>We heard that you lost your Naukriyan.com password. Sorry about that!..</p>
        <p>But don’t worry! You can click below button to reset your password.</p>
        <button><a href="{{ Route('forget-password-user.form', $userData['token']) }}">Click Here</a></button>
        <br>
        <br>
        If you don’t use this link within 30 minutes, it will expire. To get a new password reset link, visit <a
            href="{{ url('/forget#/') }}">Click Here</a> <br>
        <br>
        <p>For any issues related to the system you can send us an email at <a
                href="mailto:info@naukriyan.com">info@naukriyan.com</a>
            <br>
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
