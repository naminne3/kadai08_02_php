//データベースに送る

<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

// POSTデータを取得
$title = $_POST["title"];
$naiyou = $_POST["naiyou"];
$hashtag = $_POST["hashtag"]; 
$hashtag = "#" . str_replace(" ", " #", $hashtag); // スペースを"#"に置換
$memo = $_POST["memo"];

// データベースに登録
try {
    $stmt = $pdo->prepare("INSERT INTO gs_an_table(title, naiyou, memo, indate, hashtag) VALUES (:title, :naiyou, :memo, sysdate(), :hashtag)");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 登録成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("index.php");
}
?>