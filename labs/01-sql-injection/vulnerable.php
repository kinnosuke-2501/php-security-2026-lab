<?php
// ⚠ わざと脆弱に書いたログイン処理。絶対に真似しないでください。
require __DIR__ . '/../common/db.php';
require __DIR__ . '/../common/layout.php';
lab_header('01. SQLインジェクション', 'vuln');

$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // 問題点: 入力値をそのままSQL文に連結している。
    // 入力が「文字列データ」ではなく「SQL命令の一部」として扱われてしまう。
    $sql = "SELECT id, username, is_admin FROM users
            WHERE username = '$user' AND password = '$pass'";
    echo "<div class='box'>実行されるSQL:<br><code>" . htmlspecialchars($sql) . "</code></div>";

    $res = db()->query($sql);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $result = "ログイン成功！ ようこそ " . htmlspecialchars($row['username']) .
                  " さん (admin=" . $row['is_admin'] . ")";
    } else {
        $result = "ログイン失敗";
    }
}
?>
<p>正しいIDとパスワードでログインできます。ですが <code>exploit.md</code> の入力を使うと、パスワードを知らなくても突破できてしまいます。</p>
<form method="post">
  <label>ユーザー名<input name="username"></label>
  <label>パスワード<input name="password"></label>
  <button type="submit">ログイン</button>
</form>
<?php
if ($result !== null) echo "<div class='box'><b>$result</b></div>";
lab_footer();
