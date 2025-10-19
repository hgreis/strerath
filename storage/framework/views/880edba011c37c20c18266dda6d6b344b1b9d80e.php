<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senex-Logistics</title>
    <style type="text/css"> 
        .head {
            color: darkred;
            font-size: 40px;
            font-weight: bold;    
            font-family:arial ;
            margin: 30px;
            text-align: center;
        }
        .logo {
            width: 200px;
            float: right;
            margin-right: 20px;
        }
        .address {
            font-size: 12px;
            margin-left: 20px;
            margin-bottom: 100px;
            line-height: 0.3;
        }
    </style>
</head>

<body>
    <div class="head">
        <p>STRERATH Transporte</p>
    </div>

    <div class="address">
        <img src="images/sh logo.jpg" class="logo">
        <p style="font-size: 10px; color: red;">Absender-Adresse</p>
        <p>Ziel - Strasse</p>
        <p>Ziel - Stadt</p>
        <p>Ziel - Land</p>
    </div>

    <div>
        <p style="text-align: right;">Datum</p>
        <p style="font-size: 20px;">Rechnungsnummer</p>
    </div>


    <h1>Rechnung generieren</h1>
<?php echo e($filename); ?>



</body>
</html><?php /**PATH /var/www/StrerathTransporte/resources/views/pdf-view.blade.php ENDPATH**/ ?>