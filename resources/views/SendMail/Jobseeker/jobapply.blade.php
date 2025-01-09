<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0;">
    <div style="width: 100%; background: #e5e5e5;padding: 15px 0;">
        <table style="width: 600px; margin: 0 auto; background-color: #ffffff">
            <thead>
                <tr style="width:100%">
                    <td style="background-color:#fff;text-align: center;padding-top: 12px;padding-bottom: 6px; ">
                         <img src="https://naukriyan.com/company_logo/{{$mailData['logo']}}" alt="Logo">
                    </td>
                </tr>
            </thead>
            <tbody style="padding-left: 20px">
                <tr>
                	<center><h2 style="font-family: Calibri;">Welcome</h2></center>
                    <h3 style="font-family: Calibri;">Hi {{$mailData['name']}},</h3>
                     <p>Thank you for applying for the {{$mailData['job_title']}} position at {{$mailData['company']}}. We are pleased to confirm that your application has been successfully received.<p>

                    <p>Our team is currently reviewing all applications, and we will be in touch with you shortly regarding the next steps in the recruitment process. We appreciate your interest in joining our team and your time in applying.</p>

                    <p>Thank you again for your application. We look forward to speaking with you soon. </p>
                     
                </tr>
                <tr>
                    
                        <p>If you have any question,just email to given email.we are always happy to help out.</p>
                        <p style='font-weight:bold'> Best Regards </p>
                        <p > Team naukriyan.com </p><p> Email: admin@naukriyan.com </p>
                        <p > follow us on <a href="#">facebook</a></p>
                        <p > follow us on <a href="#">Linkedin</a></p>
                  
                </tr>
                <tr style="background-color: #e35f14;">
                    <td>
                        <div style="text-align: center; padding-left: 20px; padding-right: 20px; font-family: Calibri; color: #fff;font-size: 12px">
                            <p>Naukriyan.com<br></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>


</html>


