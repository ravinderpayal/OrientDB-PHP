# **OrientDB-PHP**
### A simple and minimal yet powerful class / PHP-driver for connecting your PHP code to to OrientDB over rest API

####**How to Use PHP - DRIVER / Class**

`<?php`
`require_once("orientDB.php");`

`$odb = new OrientDB($host,$username,$password);`

`$odb->connect();`

`$resultArray = $odb->query($dbname,$query);`

`/*********************************`

`Your JOB`

`***************************/`

`$odb->close();`

`?>`
