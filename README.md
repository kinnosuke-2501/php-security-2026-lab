# 🔐 PHP脆弱性検証ラボ（学習用・個人用）

> ⚠️ **このリポジトリは教育・学習目的専用です。本番環境での実行・悪用は固く禁じます。**

---

## 1. リポジトリの目的

このリポジトリは、**PHPの脆弱性とその対策を、実際に手を動かして学ぶ**ための個人用学習ポケットリポジトリです。

2026年10月に大きな話題となった深刻なPHP脆弱性（**php2shell**：CVE-2026-109618 / CVE-2026-109619）を主題として、以下を理解することを目的としています。

- 攻撃がどのような仕組みで成立するのか
- なぜ危険なのか
- どのような修正・対策が有効なのか

セキュリティに詳しくない人・PHPや脆弱性を初めて学ぶ人でも理解できるよう、できるだけわかりやすい説明と手順を心がけています。

---

## 2. このリポジトリで学ぶ内容

| テーマ | 内容 |
|--------|------|
| 脆弱性の仕組み | CVE-2026-109618 / CVE-2026-109619（php2shell）の概要 |
| 攻撃の再現（PoC） | ローカル環境で攻撃がどう成立するかを確認する |
| 安全なコードとの比較 | 脆弱なコードと修正済みコードを並べて確認する |
| 対策の実践 | パッチ適用・設定変更・WAFルールなどの対策方法 |

> **PoC（Proof of Concept）** とは：「実際に動くことを確認する概念実証」のことです。攻撃の仕組みを理解するために、ローカル環境で再現してみることを指します。

---

## 3. 注意事項

```
⚠️ 重要：必ず読んでください
```

- 🚫 **本番環境での使用は絶対に禁止です**
- 🚫 **悪用・不正アクセスへの転用は固く禁じます**
- 🚫 **外部に公開されたサーバーでは絶対に実行しないでください**
- ✅ **ローカル環境（自分のPC）または隔離されたコンテナ内でのみ実行してください**
- ✅ このリポジトリは **教育目的のみ** を意図しています
- ✅ 学習後は検証環境を適切に削除・停止してください

---

## 4. ディレクトリ構成

```
php-security-2026-lab/
├── README.md                   # このファイル
├── docker-compose.yml          # ローカル検証環境の構成
├── vulnerable/                 # 脆弱なコードのサンプル（PHP2shell再現用）
│   ├── index.php
│   └── upload.php
├── patched/                    # 修正済み・安全なコードのサンプル
│   ├── index.php
│   └── upload.php
├── exploit/                    # PoCスクリプト（ローカル検証専用）
│   └── poc_php2shell.py
└── docs/                       # 補足説明・参考資料まとめ
    ├── vulnerability_overview.md
    └── mitigation_guide.md
```

---

## 5. 前提条件

以下のソフトウェアがインストールされていることを確認してください。

| ツール | バージョン目安 | 用途 |
|--------|--------------|------|
| Docker | 24.x 以上 | コンテナ環境の構築 |
| Docker Compose | v2.x 以上 | 複数コンテナの管理 |
| Python | 3.10 以上 | PoCスクリプトの実行 |
| Git | 任意 | このリポジトリのクローン |

> **Docker** とは：アプリケーションを「コンテナ」という仮想の箱の中で動かすツールです。ローカルPC上に隔離された環境を簡単に作れます。

---

## 6. 環境構築手順

### ① リポジトリをクローンする

```bash
git clone https://github.com/kinnosuke-2501/php-security-2026-lab.git
cd php-security-2026-lab
```

### ② 脆弱な検証環境を起動する

```bash
docker-compose up -d
```

### ③ ブラウザで確認する

```
http://localhost:8080
```

### ④ 環境を停止・削除する（学習後は必ず実施）

```bash
docker-compose down --volumes
```

---

## 7. 例として扱う脆弱性の説明

### php2shell（CVE-2026-109618 / CVE-2026-109619）

2026年10月に公開された、PHPエンジン本体に存在する**非常に深刻な脆弱性**です。
CVSS（脆弱性の深刻度スコア）は **9.2（Critical：緊急）** と評価されています。

#### CVE-2026-109618

- **種別**：メモリ不足（OOM）時のエラー処理の不備
- **影響**：細工されたHTTPリクエストを送るだけで、サーバー上で任意のコード（命令）を実行できる
- **影響バージョン**：PHP 8.2 〜 8.5 系（それ以前も対象の可能性あり）

#### CVE-2026-109619

- **種別**：Use After Free（解放済みメモリの再利用）
- **影響**：複数のリクエストを連続して送ることで、不完全なグローバル状態を悪用できる
- **影響バージョン**：CVE-2026-109618 と同様

#### なぜ危険なのか？

- 認証が不要（ログイン不要）で攻撃が成立する
- ファイルアップロード機能がなくても攻撃できる場合がある
- WordPress・Laravel・Symfony など人気フレームワーク全般に影響する
- mod_php・PHP-FPM・php-cgi など主要な動作方式すべてが対象

---

## 8. どのように再現するか（PoC手順）

> ⚠️ **必ずローカルのDockerコンテナ内でのみ実行してください。**

### 手順

#### 1. 脆弱な環境を起動

```bash
docker-compose up -d
```

#### 2. PoCスクリプトを実行

```bash
cd exploit
python3 poc_php2shell.py --target http://localhost:8080
```

#### 3. 結果を確認

コマンドが実行できた場合、ターミナルに出力が表示されます。
これにより「リモートコード実行（RCE）が成立した」ことが確認できます。

> **RCE（Remote Code Execution）** とは：攻撃者が離れた場所からサーバー上で任意のコマンドを実行できる脆弱性です。

---

## 9. 修正方法の説明

以下の対策が有効です。

### ✅ 最も効果的な対策：PHPをアップデートする

| 現在のバージョン | 安全なバージョン |
|-----------------|----------------|
| PHP 8.5.x | 8.5.12 以降 |
| PHP 8.4.x | 8.4.27 以降 |
| PHP 8.3.x | 8.3.36 以降 |
| PHP 8.2.x | 8.2.35 以降 |
| PHP 8.1 以前 | サポート終了のため早急に移行が必要 |

```bash
# バージョン確認
php -v

# パッケージマネージャ経由でのアップデート例（Ubuntu）
sudo apt update && sudo apt upgrade php
```

### ✅ 暫定的な緩和策（パッチ適用までの一時対応）

```ini
; php.ini に以下を設定（一部の攻撃経路を遮断）
session.upload_progress.enabled = 0
```

> ただし、この設定だけでは完全な防御にはなりません。必ずPHP本体のアップデートを優先してください。

### ✅ WAF（Web Application Firewall）の活用

AWS WAF・Cloudflare WAF などで `multipart/form-data` を含む不審なリクエストを一時的にブロックする設定が各社から提供されています。

---

## 10. 安全なコードの例

### 脆弱なコード例（`vulnerable/upload.php`）

```php
<?php
// ❌ 危険な例：ユーザー入力をそのままファイル操作に使用
$filename = $_GET['file'];
include($filename);  // 任意のファイルを読み込める
?>
```

### 修正済みの安全なコード例（`patched/upload.php`）

```php
<?php
// ✅ 安全な例：許可リスト（ホワイトリスト）で入力を検証する
$allowed_files = ['about.php', 'contact.php', 'faq.php'];
$filename = $_GET['file'] ?? '';

if (!in_array($filename, $allowed_files, true)) {
    http_response_code(400);
    echo '不正なリクエストです。';
    exit;
}

include(__DIR__ . '/pages/' . $filename);
?>
```

#### 変更点の解説

| 項目 | 脆弱なコード | 安全なコード |
|------|------------|------------|
| 入力の検証 | なし | 許可リストで検証 |
| ファイルパスの制限 | なし | `__DIR__` で限定 |
| 不正入力時の処理 | なし | 400エラーで終了 |

---

## 11. 学習の進め方

おすすめの学習ステップを以下に示します。

```
STEP 1: まずこのREADMEを最後まで読む
   ↓
STEP 2: docs/vulnerability_overview.md で脆弱性の仕組みを理解する
   ↓
STEP 3: vulnerable/ フォルダのコードを読んで「どこが問題か」を考える
   ↓
STEP 4: Docker環境を起動してPoCを実行し、攻撃が成立することを確認する
   ↓
STEP 5: patched/ フォルダのコードと比較して、何が改善されているかを確認する
   ↓
STEP 6: docs/mitigation_guide.md で対策の全体像を整理する
   ↓
STEP 7: 自分でコードを修正してみて、攻撃が防げることを確認する
```

> 焦らず1ステップずつ進めましょう。脆弱性の仕組みを理解することが、安全なコードを書く第一歩です。

---

## 12. 参考資料

| 資料 | URL |
|------|-----|
| IPA（情報処理推進機構）注意喚起 | https://www.ipa.go.jp/security/security-alert/2026/alert20261022.html |
| JPCERT/CC 注意喚起 | https://www.jpcert.or.jp/at/2026/at260033.html |
| GMO Flatt Security Blog（詳細解説） | https://blog.flatt.tech/entry/php2shell |
| piyolog（まとめ記事） | https://piyolog.hatenadiary.jp/entry/2026/10/21/174516 |
| AWS WAF 暫定対策ガイド | https://aws.amazon.com/jp/blogs/news/using-aws-waf-to-apply-mitigations-for-php2shell-rce-vulnerabilities-cve-2026-109618-and-cve-2026-109619/ |
| PHP 公式サイト | https://www.php.net/downloads |

---

## ライセンス

このリポジトリのコードはすべて学習目的のサンプルです。商用・本番利用を意図したものではありません。

---

> **📌 This repository is for educational purposes only.**
> The code and PoC scripts in this repository are intended solely for learning about PHP security vulnerabilities in isolated local environments.
> Do NOT use any content in this repository for unauthorized access, malicious activities, or production systems.
> The author assumes no responsibility for any misuse of the content provided here.
