<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';

$ga = new PHPGangsta_GoogleAuthenticator();
$secret = $ga->createSecret();
$secret = "FGHMS4B56QGRJMOS";

//echo "Secret is: ".$secret."\n\n";

$qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret);
//echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";

//$oneCode = $ga->getCode($secret);
//echo "Checking Code '$oneCode' and Secret '$secret':\n";

/*
$checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
if ($checkResult) {
    echo 'OK';
} else {
    echo 'FAILED';
} */

if(isset($_POST['submit'])){
    $oneCode = $_POST['code'];    
    $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
    if ($checkResult) {
        echo 'OK';
    } else {
        echo 'FAILED';
    }
}
?>
<html>
    <body>
       <br>
        <img style="width: 200px; height: 200px;" src="<?php echo $qrCodeUrl; ?>" alt="">
        <h1><?php echo $secret?></h1>
        
        <form method="POST">
            <input type="text" name="code">
            <button type="submit" name="submit">Submit Code</button>
        </form>
    </body>
</html>
