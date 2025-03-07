<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $subject ?></title>
    <style>
        .container {
            display: block;
            margin: 32px;
            padding: 16px;
            width: 100%;
            background-color: #020506ab;
            color: #cfcfcf56;
        }
    </style>
</head>



<body>

    <div class="container">

        <?= $mailbody ?>

    </div>
    <div style="margin-top:10px;">

        <p>Best regards,</p>

    </div>

</body>



</html>