<!-- // ブログ記事一覧表示 -->

<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
// sschk(); 

// 記事データを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC");
    $status = $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}


// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>記事一覧</h2>

<?php if (isset($_SESSION["chk_ssid"])) : ?> 
    <p><a href="new.php">新規投稿</a></p>
<?php endif; ?>

<?php if (count($articles) > 0) : ?>
    <ul>
        <?php foreach ($articles as $article) : ?>
            <li>
                <a href="article.php?id=<?php echo h($article['id']); ?>">
                    <?php echo h($article['title']); ?> 
                </a>
                (<?php echo h($article['indate']); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>記事がありません。</p>
<?php endif; ?>

<?php
// フッターを読み込み
include("templates/footer.php");
?>