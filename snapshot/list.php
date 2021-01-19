<?php
// 外部ファイルの読み込み
require_once "db.php";
require_once "Product.php";
?>
<?php
$products = [];  
$pstmt = null; 
try {
	$pdo = connectDB();
	$sql = "select * from product";
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute();
	$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	$user = null;
	foreach ($records as $record) {
	    $id = $record["id"];
		$name = $record["name"];
		$price = $record["price"];
		$category = $record["category"];
		$image = $record["image"];
		$detail= $record["detail"];
		// Userクラスをインスタンス化
		$product = new Product($id, $name, $price, $category, $image,$detail);
		// 配列に格納
		$products[] = $product;
	}
} catch (PDOException $e) {
	// 1-7. エラーメッセージを表示して強制終了
	echo $e->getMessage();
	die;
} finally {
	// 1-8. データベース関連オブジェクトの解放
	unset($pstmt);
	unset($pdo);
}
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
<section id="list">
	<h2>商品一覧</h2>
	<form name="product_list">
	<table class="list">
		<tr>
			<th>商品ID</th>
			<th>カテゴリ</th>
			<th>商品名</th>
			<th>価格</th>
			<th></th>
		</tr>
		<?php foreach ($products as $product): ?>
		<tr>
			<td><?= $product->getId() ?></td>
			<td><?= $product->getCategory() ?></td>
			<td><?= $product->getName() ?></td>
			<td><?= $product->getPrice() ?></td>
			<td><?= $product->getDetail() ?></td>
			
			
			<td class="buttons">
				<form name="inputs">
					<input type="hidden" name="id" value="<?= $product->getId() ?>" />
					<button formaction="update.php" formmethod="post" name="action" value="update">更新</button>
					<button formaction="confirm.php" formmethod="post" name="action" value="delete">削除</button>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
		
	</table>
</section>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>