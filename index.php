<!doctype html><html lang="ja"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PHP脆弱性検証ラボ</title>
<style>
 body{font-family:system-ui,sans-serif;max-width:760px;margin:2rem auto;padding:0 1rem;line-height:1.6;color:#222}
 .card{border:1px solid #ddd;border-radius:8px;padding:1rem 1.2rem;margin:1rem 0}
 .card h2{margin:.2rem 0}
 .links a{margin-right:1rem}
 .warn{background:#fff8e0;border:1px solid #e8d48a;border-radius:6px;padding:.8rem 1rem}
</style></head><body>
<h1>🔐 PHP脆弱性検証ラボ</h1>
<p class="warn">⚠ 教育・学習目的専用です。必ずこのローカル環境内だけで試してください。</p>
<p>各ラボは「わざと脆弱なコード」と「修正済みコード」を並べて比較できます。まず解説(README)を読んでから試すのがおすすめです。</p>

<div class="card">
  <h2>01. SQLインジェクション</h2>
  <p>入力値がSQL文に紛れ込み、ログインを突破したりDBを覗かれたりする攻撃。</p>
  <p class="links">
    <a href="/labs/01-sql-injection/vulnerable.php">⚠ 脆弱版</a>
    <a href="/labs/01-sql-injection/patched.php">✓ 修正版</a>
  </p>
</div>

<div class="card">
  <h2>02. XSS（クロスサイトスクリプティング）</h2>
  <p>入力したスクリプトが他の人の画面で実行されてしまう攻撃。</p>
  <p class="links">
    <a href="/labs/02-xss/vulnerable.php">⚠ 脆弱版</a>
    <a href="/labs/02-xss/patched.php">✓ 修正版</a>
  </p>
</div>

<div class="card">
  <h2>03〜05（準備中の枠）</h2>
  <p>ファイルアップロード / コマンドインジェクション / パストラバーサル。各フォルダのREADMEに学ぶ内容をまとめています。</p>
</div>

<p style="margin-top:2rem;color:#888">docs/ に環境構築・用語集・セキュリティ基礎の解説があります。</p>
</body></html>
