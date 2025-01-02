<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Completion Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        .certificate {
            border: 20px solid #0066cc;
            padding: 25px;
            height: 600px;
            position: relative;
        }
        .certificate-header {
            margin-bottom: 20px;
        }
        h1 {
            font-size: 36px;
            font-weight: bold;
            color: #0066cc;
        }
        .recipient {
            font-size: 24px;
            margin: 20px 0;
        }
        .course-name {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
        }
        .completion-date {
            font-size: 18px;
            margin: 20px 0;
        }
        .signature {
            margin-top: 40px;
            border-top: 1px solid #000;
            display: inline-block;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-header">
            <h1>Certificate of Completion</h1>
        </div>
        <p>This is to certify that</p>
        <p class="recipient">{{ $user_name }}</p>
        <p>has successfully completed the course</p>
        <p class="course-name">{{ $course_name }}</p>
        <p class="completion-date">on {{ $completion_date }}</p>
        <div class="signature">
            <p>Authorized Signature</p>
        </div>
    </div>
</body>
</html>
