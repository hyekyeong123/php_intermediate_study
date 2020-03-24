
<?php
$pdo = new PDO("mysql:host=localhost; dbname=test; charset=utf8",'user1','12345');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);