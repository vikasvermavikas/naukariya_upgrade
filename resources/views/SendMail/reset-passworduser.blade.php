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
    <style>
      body {
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
        color: #333;
        /* display: flex;
        justify-content: center;
        align-items: center; */
        height: 100vh; /* Full viewport height */
      }
      .container {
        width: 100%;
        max-width: 700px;
        background-color: #ffffff;
        border-radius: 5px;
       
        box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
      }
      .header {
        color: white;
        text-align: center;
        margin-top: 20px;
      }
      .header img{
        margin-top: 20px;
      }
      .content {
       padding: 0px 10px 10px 10px;
      }
      .footer {
        background-color: #f4f4f4;
        text-align: center;
        padding: 10px;
        font-size: 14px;
      }
      a {
        color: #007bff;
        text-decoration: none;
      }

      .btn {
      border: none;
    background: #e35e25;
    text-transform: capitalize;
    color: #fff;
    border-radius: 5px;
}
      @media only screen and (max-width: 600px) {
        .container {
          width: 100% !important;
          max-width: 100% !important;
        }
        .content {
          padding: 20px !important;
        }
        .header,
        .footer {
          font-size: 18px !important;
        }
      }
    </style>
</head>

<body>
 <div class="container">
      <div class="header">
        <img
          src="{{asset('default_images/naukriyan_logo.png')}}"
          alt="Naukriyan Logo"
          style="width: 200px; height: auto"
        />
      </div>
      <div class="content">
        <h4>Dear User,</h4>
        <p>
          We heard that you lost your Naukriyan.com password. Sorry about that!..<br>
        But don’t worry! You can click below button to reset your password.
        </p>
       <button type="button" class="btn">Reset Password</button>
       <p class="m-2">
        If you don’t use this link within 30 minutes, it will expire. To get a new password reset link, visit 
      </p>
      <button type="button" class="btn">Click Here</button>
      <p></p>
      For any issues related to the system you can send us an email at info@naukriyan.com 
      Thanks & Regards,
      Team Naukriyan       
      </p>
      <ul>
        <li><a href="">Website : www.naukriyan.com </a> </li>
        <li><a href="">Email: info@naukriyan.com</a> </li>
        <li><a href="">Contact:+91-1179626411</a> </li>
      </ul>
      </div>
      
    </div>
</body>

</html>
