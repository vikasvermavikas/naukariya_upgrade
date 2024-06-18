
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
                	<center><h2 style="font-family: Calibri;">New Query Generated</h2></center>
                    <center><h3 style="font-family: Calibri;">Details Are Below-</h3></center>
                    <p style="font-family: Calibri; margin-left: 20px"> Name -: {{$name}} </p>
                    <p style="font-family: Calibri; margin-left: 20px"> Contact No- -: {{$mobile}} </p>
                    <p style="font-family: Calibri; margin-left: 20px"> Email -: {{$email}} </p>
                    <p style="font-family: Calibri; margin-left: 20px"> Query -: {{$remarks}} </p>

                     
                   
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
