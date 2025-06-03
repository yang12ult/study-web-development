<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WEB開発第3回</title>
</head>
<body>
    <div>
        <?php
        $array=[ 
            'Apple'=>'りんご' ,         
            'lemon'=>'レモン' ,          
            'Grape'=>'ぶどう' ,
            'Tomato'=>'トマト',
        ];
        foreach($array as $key=>$value){
            print("英語 : ".$key."<br>");
            print("日本語 : ".$value."<br>");
        }
        
        ?>
    </div>
</body>
</html>
