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
<section id="entry">
	<h2>商品の登録</h2>
	<p class="note">商品名と価格は<em>必須入力</em>です。</p>
	<form class="entry" name="product_entry">
		<table class="form">
			<tr>
				<th>カテゴリ</th>
				<td>
					<select name="category">
						<option value="財布・小物入れ">財布・小物入れ</option>
						<option value="食卓用">食卓用</option>
						<option value="その他">その他</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>商品名</th>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<th>価格</th>
				<td><input type="number" name="price">円</td>
			</tr>
			<tr>
				<th>商品説明</th>
				<td><textarea name="detail" id="" cols="30" rows="3"></textarea></td>
			</tr>
			<tr class="buttons">
				<td colspan="2">
					<button formaction="confirm.php" formmethod="post" name="action" value="entry">確認画面へ</button>
				</td>
			</tr>
		</table>
	</form>
</section>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>