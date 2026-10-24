<?php
// 各ラボページの共通レイアウト。見た目を整えるだけで、セキュリティには関係しません。
function lab_header(string $title, string $kind = '') {
    $badge = '';
    if ($kind === 'vuln')    $badge = '<span class="badge vuln">⚠ 脆弱なコード</span>';
    if ($kind === 'patched') $badge = '<span class="badge safe">✓ 修正済みコード</span>';
    echo "<!doctype html><html lang='ja'><head><meta charset='utf-8'>";
    echo "<meta name='viewport' content='width=device-width,initial-scale=1'>";
    echo "<title>$title</title><style>
      body{font-family:system-ui,sans-serif;max-width:720px;margin:2rem auto;padding:0 1rem;line-height:1.6;color:#222}
      .badge{padding:.2rem .6rem;border-radius:4px;font-size:.85rem;font-weight:bold}
      .badge.vuln{background:#ffe0e0;color:#b00020}
      .badge.safe{background:#e0f5e0;color:#0a7a2a}
      input,textarea{font-size:1rem;padding:.4rem;width:100%;box-sizing:border-box;margin:.3rem 0}
      button{font-size:1rem;padding:.5rem 1rem;cursor:pointer}
      .box{background:#f6f6f6;border:1px solid #ddd;border-radius:6px;padding:1rem;margin:1rem 0}
      a.back{display:inline-block;margin-bottom:1rem}
      table{border-collapse:collapse;width:100%}td,th{border:1px solid #ccc;padding:.4rem}
    </style></head><body>";
    echo "<a class='back' href='/index.php'>← ラボ一覧に戻る</a><h1>$title $badge</h1>";
}
function lab_footer() { echo "</body></html>"; }
