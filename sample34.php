<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Numbers from 1 to 365</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }
        .number-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        
    </style>
</head>
<body>
    <h1>Numbers from 1 to 365</h1>
    <div class="number-grid">
        <?php
        for ($i = 1; $i <= 365; $i++) {
            echo "<div class='number'>$i</div>";
        }
        ?>
    </div>
</body>
</html>

