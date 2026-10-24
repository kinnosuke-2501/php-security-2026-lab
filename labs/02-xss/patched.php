<?php
// ✓ 修正版: 出力時に htmlspecialchars() でエスケープする。
require __DIR__ . '/../common/db.php';
require __DIR__ . '/../common/layout.php';
lab_header('02. XSS（クロスサイトスクリプティング）', 'patched');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare("INSERT INTO comments (author, body) VALUES (?, ?)");
    $author = $_POST['author'] ?? '匿名';
    $body   = $_POST['body'] ?? '';
    $stmt->bind_param('ss', $author, $body);
    $stmt->execute();
}
function e(string $s): string {        // 出力エスケープ用ヘルパー
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<p>同じスクリプトを投稿しても、今度はただの文字として表示されるだけです。</p>
<form method="post">
  <label>名前<input name="author"></label>
  <label>コメント<textarea name="body"></textarea></label>
  <button type="submit">投稿</button>
</form>
<h2>コメント一覧</h2>
<?php
$res = db()->query("SELECT author, body, created_at FROM comments ORDER BY id DESC");
while ($row = $res->fetch_assoc()) {
    // ポイント: 画面に出す直前に必ずエスケープする。
    echo "<div class='box'><b>" . e($row['author']) . "</b><br>" . e($row['body'])
       . "<br><small>" . e($row['created_at']) . "</small></div>";
}
lab_footer();
