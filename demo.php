<?php

setcookie('char', '123456', time()+3600);

?>
<!DOCTYPE html>
<html>
<head>
    <title>验证码demo</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0,minimum-scale=0.5">
    <style>

    </style>
</head>
<body>
<div id="app">
    <img src="captcha.php">
</div>
</body>
</html>

