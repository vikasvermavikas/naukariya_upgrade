<table style="width: 600px; margin: 0 auto; background-color: #ffffff">
    <thead>
        <tr style="width:100%">
            <td style="background-color:#fff;text-align: center;padding-top: 12px;padding-bottom: 6px; ">
                <img src="https://naukriyan.com/company_logo/{{ $jsdata['companylogo'] }}" alt="Logo">

            </td>
        </tr>
    </thead>
</table>
<p>Dear {{ $jsdata['jsname'] }},</p>
<p>Your Application ID -{{ $jsdata['jsapplicationid'] }}</p>
<p>Congratulations from {{ $jsdata['companyname'] }} </p>
<p>We have scheduled your interview on {{ date('F j, Y, g:i a', strtotime($jsdata['interview_date'])) }}</p>
<p>{!! $jsdata['interview_info'] !!}</p>


<p>If you face any issues, please contact us at below information.</p>
<br>
<br>
<br>
<br>

<hr>
Regards,<br>
Hr Team,<br>
{{ $jsdata['companyname'] }} <br>
{{ $jsdata['companyaddress'] }}<br>
Email : {{ $jsdata['empemail'] }} , {{ $jsdata['companyemail'] }} <br>
Conatct : {{ $jsdata['empcontact'] }},{{ $jsdata['companycontact'] }} <br>
Website : {{ $jsdata['companywebsite'] }} <br>
