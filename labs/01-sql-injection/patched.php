<?php
// ✓ 修正版: プリペアドステートメント（プレースホルダ）を使う。
require __DIR__ . '/../common/db.php';
require __DIR__ . '/../common/layout.php';
lab_header('01. SQLインジェクション', 'patched');

$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // ポイント: ? の部分は必ず「ただの値」として扱われる。
    // ユーザー入力がSQL命令として解釈されることはない。
    $stmt = db()->prepare(
        "SELECT id, username, is_admin FROM users WHERE username = ? AND password = ?"
    );
    $stmt->bind_param('ss', $user, $pass);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $result = "ログイン成功！ ようこそ " . htmlspecialchars($row['username']) .
                  " さん (admin=" . $row['is_admin'] . ")";
    } else {
        $result = "ログイン失敗";
    }
}
?>
<p>同じ攻撃入力を試しても、今度は突破できないことを確認してください。</p>
<form method="post">
  <label>ユーザー名<input name="username"></label>
  <label>パスワード<input name="password"></label>
  <button type="submit">ログイン</button>
</form>
<?php
if ($result !== null) echo "<div class='box'><b>$result</b></div>";
lab_footer();
