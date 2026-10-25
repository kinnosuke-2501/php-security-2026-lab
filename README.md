# 🔐 PHP脆弱性検証ラボ（学習用・個人用）

> ⚠️ **教育・学習目的専用です。ローカルの隔離環境（Docker）以外では実行しないでください。**

PHPとセキュリティの初心者が、**「脆弱なコードを書く → 攻撃してみる → 修正する」** を手を動かして学ぶためのリポジトリです。

## 構成

```
php-security-2026-lab/
├── README.md                  # このファイル（目次）
├── docker-compose.yml         # 隔離環境（PHP 8.2 + Apache / MySQL 8）
├── docker/                    # Dockerfile, php.ini, DB初期データ
├── index.php                  # ブラウザで開くラボ一覧ページ
├── docs/
│   ├── 00_setup.md            # 環境構築・停止方法
│   ├── 01_security_basics.md  # Webセキュリティの基礎と学習の進め方
│   └── glossary.md            # 用語集
├── labs/                      # 手を動かす教材（1フォルダ = 1レッスン）
│   ├── common/                # DB接続・共通レイアウト
│   ├── 01-sql-injection/      # ✅ README / vulnerable.php / patched.php / exploit.md
│   ├── 02-xss/                # ✅ 同上
│   ├── 03-file-upload/        # 🚧 準備中（READMEのみ）
│   ├── 04-command-injection/  # 🚧 準備中
│   └── 05-path-traversal/     # 🚧 準備中
└── appendix/
    └── php2shell-cve-2026/    # 読み物: PHP本体の脆弱性（CVE-2026-109618/109619）
```

各ラボは同じ4ファイル構成です。

| ファイル | 役割 |
|---------|------|
| `README.md` | 仕組み・原因・対策の解説 |
| `vulnerable.php` | わざと脆弱に書いたコード |
| `patched.php` | 修正済みの安全なコード |
| `exploit.md` | 攻撃を手で試す手順（PoC） |

## クイックスタート

```bash
docker compose up -d --build   # 起動（初回1〜2分）
# → http://localhost:8080 を開く
docker compose down -v         # 学習後は必ず停止・削除
```

詳しくは [docs/00_setup.md](docs/00_setup.md)。

## おすすめの学習順
1. [docs/01_security_basics.md](docs/01_security_basics.md) — 脆弱性の共通原因を知る
2. [labs/01-sql-injection](labs/01-sql-injection/) — SQLインジェクション
3. [labs/02-xss](labs/02-xss/) — XSS
4. 03〜05 — 自分でラボを作ってみる（同じ4ファイル構成で）
5. [appendix/php2shell-cve-2026](appendix/php2shell-cve-2026/) — 「コードが正しくてもPHP本体が古いと危ない」を知る

## 注意事項
- 🚫 本番環境・外部公開サーバーでは絶対に実行しない
- 🚫 自分が管理していないサイトに攻撃手法を試さない（不正アクセス禁止法違反）
- ✅ 学習後は `docker compose down -v` で環境を削除する
