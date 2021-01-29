<?php
// 外部ファイルの読み込み
require_once "db.php";
require_once "Product.php";
?>

<?php
$products = [];
$pstmt = null;

try{
    $pdo = connectDB();
    $sql = "select * from product";
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute();
    $records = $pstmt->fetchALL(PDO::FETCH_ASSOC);
    $products = null;
    
    foreach ($records as $record){
        $id = $record["id"];
        $name = $record["name"];
        $price = $record["price"];
        $category = $record["category"];
        $detail = $record["detail"];
        
        $product = new Product($id, $name, $price, $category, $detail);
        
        $products[] = $product;
    }
}catch (PDOException $e) {
	echo $e->getMessage();
	die;
} finally {
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
<main id="list">
	<h2>商品一覧</h2>
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
			<td>&yen;<?= $product->getPrice() ?></td>
			<td class="buttons">
				<form name="inputs">
					<input type="hidden" name="id" value="<?= $product->getId() ?>" />
					<button formaction="update.php" formmethod="get" name="action" value="update">更新</button>
					<button formaction="confirm.php" formmethod="get" name="action" value="delete">削除</button>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
</main>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>
