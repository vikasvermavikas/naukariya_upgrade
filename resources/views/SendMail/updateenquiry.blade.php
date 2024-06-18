



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
                         <img src="{{asset('assets/admin/default/logo1.png')}}"alt="Logo">
           
                    </td>
                </tr>
            </thead>
            <tbody style="padding-left: 20px">
                <tr>
                    <td><h2 style="font-family: Calibri; margin-left: 20px">Hi {{$name}},</h2></td>
                </tr>
                <tr>
                    <td >
                       <section >
                        <p>Your Enquiry status is Updated Successfully.</p>
                        <p>Enquiry Status is - {{$enq_status}}</p>
                        <p>Enquiry Message is - {{$enq_message}}</p>
                        <p style='font-weight:bold'> Best Regards </p>
                        <p > Team naukriyan.com </p><p> Email: admin@naukriyan.com </p>
                        <p > follow us on <a href="#">facebook</a></p>
                        <p > follow us on <a href="#">Linkedin</a></p>
                    </section>
                        <!-- <p style="font-family: Calibri; margin-left: 20px"><small>Follow us on <a href="https://www.facebook.com/jobsinabad">Facebook</a></small></p>
                        <p style="font-family: Calibri; margin-left: 20px"><small>Follow us on <a href="https://www.linkedin.com/company/jobsinaurangabad/about/">Linkedin</a></small></p> -->
                    </td>
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
