<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .container {
            margin: 0 auto;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007bff;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Good day {{ $user->institution_name }},</h1>

        <p>Thank you for submitting the requirements for <b>{{ $request->qualification->qualification_name }}</b>. As <b>{{ $user->institution_name }}</b> Administrators, you may now onboard the students in the Multi-Regional TESDA Online Program. Please see the Onboarding Process below:</p>

        <ol>
            <li>The TTI LMS Administrator shall set up the course site in their category within the Multi-Regional TOP:
                <ul>
                    <li>Set up course enrolment key, and group enrolment key.</li>
                    <li>Prepare TOP user credentials for trainees, as deemed necessary.</li>
                    <li>Provide teacher access to the trainer.</li>
                    <li>Assign Roles for Regional and TTI Administrator.</li>
                </ul>
            </li>
            <li>The TTI LMS Administrator shall then orient the trainer with the guidelines on the enhancement of courses, provision of technical support, an overview of the Multi-Regional TOP, and the TESDA Online Program Mobile App.</li>
            <li>The Trainer shall be asked to upload the study guides. After which, the TTI LMS Administrator will now provide trainees with access to the Regional and TTI Category, and the trainer a self-enrolment key for the courses.</li>
            <li>The Trainer can now run the flexible learning delivery of the program. The TTI LMS Administrator shall provide technical assistance during the conduct of the training program.</li>
        </ol>

        <p>For documentation purposes, please do not forget to accomplish the following forms:</p>
        <ul>
            <li><p>Link of Monitoring of EGAC: <a href="https://docs.google.com/spreadsheets/d/1RKqy1vGADSM-6Jj6fCnMEIC73MaAmZ218QQj1m8NTxA/edit?gid=24206125#gid=24206125">Click Here</a></p></li>
            <li><p>Survey Form for Trainees: <a href="https://lookerstudio.google.com/u/0/reporting/9d56a6e6-a41c-4adb-b5b0-60543471ee66/page/p_uow3nfiodd">Click Here</a></p></li>
            <li><p>Survey Form for Trainers: <a href="https://docs.google.com/forms/d/e/1FAIpQLSe3s4ZHq1zpru3e1qV96ItM6Vrw_btnQVucCPMsGlXJcDhS-w/viewform">Click Here</a></p></li>
        </ul>

        <p>You can verify your MRTOP monitoring status at this: <a href="https://lookerstudio.google.com/u/0/reporting/9d56a6e6-a41c-4adb-b5b0-60543471ee66/page/p_uow3nfiodd">Link</a>.</p>

        <p>Should you have any questions, feel free to contact us via the FB LMS Technical Support Group Chat.</p>

        <p>Thank you!</p>

        <div class="footer">
            <p>Regards,</p>
            <p>Information Technology Team<br>eTESDA Division</p>
        </div>
    </div>
</body>
</html>
