<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<?php

    $hours = 24;
    $minutes = 60;
    $seconds = 60;

    $totalSeconds = $hours * $minutes * $seconds;
echo"<h1>1日が何秒であるか</h1>" ;
echo"<p> 24時間 * 60分 * 60秒 = {$totalSeconds}</p>";
?>
</body>
</html>
