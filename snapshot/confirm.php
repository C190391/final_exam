<?php
require_once "db.php";
require_once "Product.php";
?>
<?php
$action = $_REQUEST["action"];
$user = null;
$title = "";

/* 2. 処理の分岐 */
if ($action === "signup" or $action === "update") {
	/* 2-1-1. 登録処理における［登録］ボタンまたは［更新］ボタンがクリックされて遷移した場合の処理：リクエストパラメータを表示する */
	isset($_POST["id"])? $id = $_POST["id"]: $id = 0;
	isset($_POST["name"])? $name = $_POST["name"]: $name = "";
	isset($_POST["price"])? $price = $_POST["price"]: $price = 0;
	isset($_POST["category"])? $category = $_POST["category"]: $category = "";
	isset($_POST["image"])? $image = $_POST["image"]: $image = "";
	isset($_POST["detail"])? $detail = $_POST["detail"]: $detail = "";
	// 2-1-2. 新規追加するユーザまたは更新するユーザをインスタンス化
	$product = new Product($id, $name, $price, $category, $image, $detail);

} else if ($action === "delete") {
	/* 2-3. ［削除］ボタンがクリックされて遷移した場合 */
	try {
		// 2-3-1. リクエストパラメータを取得
		isset($_GET["id"])? $id = $_GET["id"]: $id = 0;
		// 2-3-2. データベース接続オブジェクトのインスタンス化
		$pdo = connectDB();
		// 2-3-3. 実行するSQLの設定
		$sql = "select * from user where id = ?";
		// 2-3-4. SQL実行オブジェクトを取得
		$pstmt = $pdo->prepare($sql);
		// 2-3-5. プレースホルダにパラメータを設定
		$pstmt->bindValue(1, $id);
		// 2-3-6. SQLを実行
		$pstmt->execute();
		// 2-3-7. 実行結果を取得
		$records = $pstmt->fetchALL(PDO::FETCH_ASSOC);
		// 2-3-8. 実行結果からUserクラスをインスタンス化
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
		// 2-3-9. メッセージを表示して強制終了
		echo $e->getMessage();
		die;
	} finally {
		// 2-3-10. データベース関連オブジェクトの解放
		unset($pstmt);
		unset($pdo);
	}
	$title = "削除";
}
// 2-4. セッションに設定
session_start();
$_SESSION["product"] = $product;
if ($action === "signup") $title = "登録";
if ($action === "update") $title = "更新";
if ($action === "delete") $title = "削除";
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
<section id="confirm">
	<h2>商品の確認</h2>
	<p>以下の情報で更新します。</p>
	<form name="product_confirm">
	<table class="form">
	    <?php if ($action !== "signup"): ?>
		<tr>
			<th>商品ID</th>
			<td><?= $product->getId() ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th>カテゴリ</th>
			<td><?= $product->getCategory() ?></td>
		</tr>
		<tr>
			<th>商品名</th>
			<td><?= $product->getName() ?></td>
		</tr>
		<tr>
			<th>価格</th>
			<td><?= $product->getPrice() ?></td>
		</tr>
		<tr>
			<th>商品説明</th>
			<td><?= $product->getDetail() ?></td>
		</tr>
		<tr class="buttons">
			<td colspan="2">
				<form name="inputs">
					<button formaction="complete.php" formmethod="post" name="action" value="execute">実行する</button>
				</form>
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