-- 学習用のサンプルデータ。コンテナ初回起動時に自動で読み込まれます。
USE vulnlab;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,   -- 学習用のため平文。実際は必ずハッシュ化します
  email VARCHAR(100),
  is_admin TINYINT DEFAULT 0
);

INSERT INTO users (username, password, email, is_admin) VALUES
  ('alice', 'alice123', 'alice@example.com', 0),
  ('bob',   'bob12345', 'bob@example.com',   0),
  ('admin', 'SuperSecretAdminPass!', 'admin@example.com', 1);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price INT NOT NULL
);

INSERT INTO products (name, price) VALUES
  ('りんご', 120), ('みかん', 80), ('ぶどう', 400);

CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  author VARCHAR(50) NOT NULL,
  body TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
