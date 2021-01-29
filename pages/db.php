<?php
/**
 * データベース接続オブジェクトを取得する。
 * @return PDO
 */
function connectDB():PDO {
	// データベース接続情報文字列
	$dsn = "mysql:host=localhost;dbname=productdb;charset=utf8";
	$user = "productdb_admin";
	$password = "admin123";
	// データベース接続オブジェクトをインスタンス化
	$pdo = new PDO($dsn, $user, $password);
	// データベース接続オブジェクトを返す
	return $pdo;
}

