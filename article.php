// 記事詳細表示
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
// sschk(); 

// GETパラメータから記事IDを取得
$id = $_GET["id"];

// 記事データを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2><?php echo h($article['title']); ?></h2>

<p>投稿日: <?php echo h($article['indate']); ?></p>

<p><?php echo h($article['naiyou']); ?></p>

<?php if (!empty($article['hashtag'])) : ?>
    <p>ハッシュタグ: <?php echo h($article['hashtag']); ?></p>
<?php endif; ?>  

<?php if (isset($_SESSION["kanri_flg"]) && $_SESSION["kanri_flg"] == 1) : ?>

    <a href="https://lifecareerdesign.sakura.ne.jp/kadai09_php/edit.php?id=<?php echo h($article['id']); ?>">編集</a>
    <a href="delete.php?id=<?php echo h($article['id']); ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
<?php endif; ?>

<?php
// フッターを読み込み
include("templates/footer.php");
?>