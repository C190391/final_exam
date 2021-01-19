<?php
// 外部ファイルの読み込み
require_once "db.php";
require_once "Product.php";
?>
<?php
$action = $_POST["action"];
$title = "";
session_start();
$product = $_SESSION["product"];

if ($action === "signup") {
	try {
		$pdo = connectDB();
		$params = [];
		$params[":name"] = $product->getName();
		$params[":price"] = $product->getPrice();
		$params[":category"] = $product->getCategory();
		$params[":detail"] = $product->getDetail();
		$pstmt = $pdo->prepare($sql);
		$pstmt->execute($params);
	} catch (PDOException $e) {
		echo $e->getMessage();
		die;
	} finally {
		unset($pstmt);
		unset($pdo);
	}
	$title = "新規productの追加";
} else if ($action === "update") {
	try {
		$pdo = connectDB();
		$sql = "update product set name = :name, price = :price, category = :category, image = :image, detail= :detail where id = :id";
		$params = [];
		$params[":id"] = $product->getId();
		$params[":name"] = $product->getName();
		$params[":price"] = $product->getPrice();
		$params[":category"] = $product->getCategory();
		$params[":image"] = $product->getImage();
	    $pstmt = $pdo->prepare($sql);
		$pstmt->execute($params);
	} catch (PDOException $e) {
		
		echo $e->getMessage();
		die;
	} finally {
		// 2-2-9. データベース接続関連オブジェクトの開放
		unset($pstmt);
		unset($pdo);
	}
	$title = "ID{$product->getId()}のユーザの更新";
} else if ($action === "delete") {
	
	try {
		$pdo = connectDB();
		$sql = "delete from user where id = ?";
		$pstmt = $pdo->prepare($sql);
		$pstmt->bindValue(1, $product->getID());
		$pstmt->execute();
	} catch (PDOException $e) {
		echo $e->getMessage();
		die;
	} finally {
		unset($pstmt);
		unset($pdo);
	}
	$title = "ID{$Product->getId()}のユーザの削除";
}
// 2-4. セッションの削除
unset($_SESSION["product"]);
unset($_SESSION);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品データベース</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<header>
	<h1>商品データベース</h1>
</header>
<section id="complete">
	<h2>商品の完了</h2>
	<p>処理を完了しました。</p>
	<p><a href="top.php">トップページに戻る</a></p>
</section>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>