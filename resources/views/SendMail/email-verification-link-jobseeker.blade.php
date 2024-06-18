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
            <img class="responsive" src="https://naukriyan.com/default_images/logo%20naukriyan.png" alt="Naukriyan">
        </center>
    </nav>
    <div class="container">
        <strong>Dear {{ $userData['name'] }},</strong><br>
        <p>Thank you for joining Naukriyan.com Job Portal. We are here to help you in finding the right job(s) .
            As you explore Naurkiyan.com you will find some innovative features that will help you in finding better
            opportunities which are available in both E-Governence and Corporate organizations.</p>

        <ul>
            <li>Video Resume</li>
            <li>Resume services (Yet to be launched).</li>
        </ul>
        <p>For any issues related to the system you can send us an email at <a
                href="mailto:info@naukriyan.com">info@naukriyan.com</a>

        <p>Please click on the link <a href="{{ route('email-verify-jobseeker', $userData['token']) }}">verify now</a>
            to verify your email address. </p><br><br>
        Thanks & Regards,<br>
        <b>Team Naukriyan</b></p>
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
