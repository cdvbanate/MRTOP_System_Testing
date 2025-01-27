<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Looker Studio Report</title>
</head>
<style>
    .report-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #f9f9f9;
    }

    .report-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<body>
    <div class="report-container">
        <!-- Replace with your actual Looker Studio embed code -->
        <<iframe width="600" height="450" src="https://lookerstudio.google.com/embed/reporting/9d56a6e6-a41c-4adb-b5b0-60543471ee66/page/p_lvj7vlvzed" 
            frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>
</body>
</html>
