<?php
require_once "db.php";
require_once "Product.php";
?>
<?php
/* 1. リクエストパラメータを取得 */
isset($_GET["id"])? $id = $_GET["id"]: $id = 0;
/* 2. 指定されたユーザをデータベースから取得 */
try {
	// 2-1. データベース接続オブジェクトのインスタンス化
	$pdo = connectDB();
	// 2-2. 実行するSQLの設定
	$sql = "select * from user where id = ?";
	// 2-3. SQL実行オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
	// 2-4. プレースホルダにパラメータを設定
	$pstmt->bindValue(1, $id);
	// 2-5. SQLを実行
	$pstmt->execute();
	// 2.6. 実行結果の配列を取得
	$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	// 2-7. 実行結果からUserクラスのインスタンスを取得
	$user = null;
	if (count($records) > 0) {
		$name = $records[0]["name"];
		$price = $records[0]["price"];
		$category = $records[0]["category"];
		$image = $records[0]["image"];
		$detail = $records[0]["detail"];
		$product = new Product($id, $name, $price, $category, $image, $detail);
	}
} catch (PDOException $e) {
	// 2-8. メッセージを表示して強制終了
	echo $e->getMessage();
	die;
} finally {
	// 2-9. データベース関連オブジェクトの解放
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
<section id="update">
	<h2>商品の更新</h2>
	<p class="note">商品名と価格は<em>必須入力</em>です。</p>
	<?php if (!is_null($product)): ?>
	<form class="update">
		<table class="form">
			<tr>
				<th>商品ID</th>
				<td>
					<input type="hidden" name="id" value="<?= $product->getId() ?>" />
						<?= $product->getId() ?>
				</td>
			</tr>
			<tr>
				<th>カテゴリ</th>
				<td>
					<select name="category">
						<option value="財布・小物入れ" <?php if ($product->getCategory() === "財布・小物入れ") echo "selected"; ?>><label for="id_a">財布・小物入れ</label></option>
						<option value="食卓用" <?php if ($product->getCategory() === "食卓用") echo "selected"; ?>><label for="id_b">食卓用</label></option>
						<option value="その他" <?php if ($product->getCategory() === "その他") echo "selected"; ?>><label for="id_c">その他</label></option>
					</select>
				</td>
			</tr>
			<tr>
				<th>商品名</th>
				<td><input type="text" name="name" value="<?= $product->getName() ?>" /></td>
			</tr>
			<tr>
				<th>価格</th>
				<td><input type="number" name="price" value="<?= $product->getPrice() ?>" />円</td>
			</tr>
			<tr>
				<th>商品説明</th>
				<td><textarea name="detail" id="" cols="30" rows="3"><?= $product->getDetaill() ?></textarea></td>
			</tr>
			<tr class="buttons">
				<td colspan="2">
					<button formaction="confirm.php" formmethod="post" name="action" value="update">確認画面へ</button>
				</td>
			</tr>
		</table>
	</form>
	<?php endif; ?>
</section>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>