<?php



//1.リロードによる重複　2.記事を一行だけ表示にしたい　3.ページ遷移


//var_dump($_); 

$title = ''; 
$text = '';
$FILE = './article.txt';
$id = uniqid(); //IDの自動生成
$now_date = date("Y-m-d H:i:s");
$DATA = []; //一回分の投稿情報
$BOARD = []; //全ての投稿情報
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
    if (!empty($_POST['title']) && !empty($_POST['txt'])){  

        //テキストの代入
        $title = $_POST['title'];
        $text = $_POST['txt'];
        //新規データ
        $DATA = [ $id, $title, $text, $now_date];
        $BOARD[] = $DATA;

        //ファイルに保存する(FILEにBOARDの内容を上書きする)関数、決まりごと
        file_put_contents($FILE, json_encode($BOARD, JSON_UNESCAPED_UNICODE)); //ユニコードされた文字をそのままの形式で表示する
    }else{
        //titleとtxtが空だったときにエラーメッセージを表示する
        if(empty($_POST['title']))$error_message[] = 'タイトルは必須です。';
        if(empty($_POST['txt']))$error_message[] = '記事は必須です。';
    }
}
//タイトルが30字以上の場合はエラーメッセージを表示する
if(strlen($_POST['title']) > 30){
    $error_message[] = 'タイトルは30字以内で入力してください。';

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
    <h2>さぁ、最新のニュースをシェアしましょう</h2>

    <!--ErrorMessageStart-->
    <?php if( !empty($error_message) ): ?>
	    <ul class="error_message">
		    <?php foreach( $error_message as $value ): ?>
			    <li><?php echo $value; ?></li>
		    <?php endforeach; ?>
	    </ul>
    <?php endif; ?>

<!--ErrorMessageEnd-->
<!--PostStart-->
     <form method="POST" class="form" onsubmit="return confirm('投稿してよろしいですか？')">
            <div class='titleContainer'>
                <lavel class='nameFlex'>タイトル：</lavel>
                <input type='text' name='title' class="inputFlex" placeholder="入力してください※30字以内">
            </div>
            <div class='articleContainer'>
                <lavel class='nameFlex'>記事：</lavel>
                <textarea name="txt" cols="50" rows="10" class="inputFlexArticle" placeholder="入力してください"></textarea>
            </div>
            <div class="submitContainer">
                <input type="submit" value="投稿" class="submitStyle">
            </div>
     </form>
    </section>
<!--PostEnd-->
<hr>
<!--ContentStart-->
    <div class="postsContainer">
        <?php foreach (array_reverse ($BOARD) as $ARTICLE) : ?>
            <div class="post">
                <p><?php echo $ARTICLE[1]; ?></p>
                <p><?php echo $ARTICLE[2]; ?></p>
                <a class="postPage" href="http://localhost/posts.php?id=<?php echo $ARTICLE[0] ?>">記事全文・コメントを見る　</a>
            </div> <hr>
        <?php endforeach; ?>
    </div>
<!--ContentStartEnd-->

<script src="index.js"></script>

</body>
</html>