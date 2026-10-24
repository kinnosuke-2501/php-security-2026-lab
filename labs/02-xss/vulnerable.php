<?php
// ⚠ わざと脆弱に書いた掲示板。入力をエスケープせずそのまま出力している。
require __DIR__ . '/../common/db.php';
require __DIR__ . '/../common/layout.php';
lab_header('02. XSS（クロスサイトスクリプティング）', 'vuln');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare("INSERT INTO comments (author, body) VALUES (?, ?)");
    $author = $_POST['author'] ?? '匿名';
    $body   = $_POST['body'] ?? '';
    $stmt->bind_param('ss', $author, $body);
    $stmt->execute();
}
?>
<p>コメントを投稿すると下に表示されます。<code>exploit.md</code> のスクリプトを投稿すると実行されてしまいます。</p>
<form method="post">
  <label>名前<input name="author"></label>
  <label>コメント<textarea name="body"></textarea></label>
  <button type="submit">投稿</button>
</form>
<h2>コメント一覧</h2>
<?php
$res = db()->query("SELECT author, body, created_at FROM comments ORDER BY id DESC");
while ($row = $res->fetch_assoc()) {
    // 問題点: $row['body'] をエスケープせずそのままHTMLに出力している。
    // 投稿に <script> が含まれると、閲覧者のブラウザで実行されてしまう。
    echo "<div class='box'><b>{$row['author']}</b><br>{$row['body']}"
       . "<br><small>{$row['created_at']}</small></div>";
}
lab_footer();
