# 00. 環境構築

## 必要なもの
| ツール | 用途 |
|--------|------|
| Docker Desktop（または Docker Engine + Compose v2） | 隔離された検証環境を動かす |
| Git | リポジトリの取得 |
| ブラウザ | ラボを操作する |

> **Docker** とは：アプリを「コンテナ」という隔離された箱の中で動かすツールです。
> 自分のPCを汚さず、壊れても `down` すれば元通りにできます。

## 起動
```bash
git clone https://github.com/kinnosuke-2501/php-security-2026-lab.git
cd php-security-2026-lab
docker compose up -d --build
```
初回はイメージのダウンロードとDB初期化に1〜2分かかります。

ブラウザで http://localhost:8080 を開くとラボ一覧が表示されます。

## よくあるトラブル
- **DB接続エラーが出る** → MySQLの起動待ちです。30秒ほど待って再読み込み。
- **8080番が使用中** → `docker-compose.yml` の `"8080:80"` を `"8081:80"` などに変更。

## 停止・リセット（学習後は必ず実施）
```bash
docker compose down -v   # -v でDBの中身（投稿したコメント等）も消える
```

## 安全のための約束
- `localhost` 以外に公開しない（ポートを外部に開けない、クラウドに置かない）
- ここで学んだ攻撃手法を、自分が管理していないサイトに試さない（不正アクセス禁止法違反になります）
