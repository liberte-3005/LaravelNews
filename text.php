<?php
//var_dump($_); 

$title = $_GET['title']; 
$text = $_GET['text'];
$FILE = './article.txt';
$DATA = []; //一回分の投稿情報
$error_message = array();

//ファイル
//$FILEが存在しているとき
if (file_exists($FILE)){
    //ファイルの読み込み
    $BOARD = json_decode(file_get_contents($FILE));
}

//投稿部
//クリックされたリクエストの判別、POSTメゾットは投稿されたという意
if ($_SERVER ['REQUEST_METHOD'] === 'POST' ){

    //titleとtxtの中身が入っているかを確認(empty(空)の!(否定))
    if (!empty($_GET['title']) && !empty($_POST['txt'])){  

        //テキストの代入
        $title = $_GET['title'];
        $text = $_GET['txt'];
        //新規データ
        $DATA = [ $id, $title, $text, $now_date];
        $BOARD[] = $DATA;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Laravel News</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    

    <nav class="navHead">
        <a class="linkItalik" href="">Laravel News</a>
    </nav>

    <section>
<!--PostStart-->
     <form method="POST" class="form">
            <div class='titleContainer'>
                <p><?php echo ($_GET["title"]) ?></p>
            </div>
            <div class='articleContainer'>
                <p><?php echo ($_GET["txt"]) ?></p>
            </div>
     </form>
    </section>
<!--PostEnd-->
<hr>

<script src="index.js"></script>

</body>
</html>