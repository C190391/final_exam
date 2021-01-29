<?php
require_once "db.php";
require_once "Product.php";
?>
<?php
isset($_GET["id"])? $id = $_GET["id"]: $id = 0;
try{
    $pdo = connectDB();
    $sql = "select * from product where id = ?";
    $pstmt = $pdo->prepare($sql);
    $pstmt->bindValue(1, $id);
    $pstmt->execute();
    $records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
    $product = null;
    if(count($records) > 0){
        $name = $records[0]["name"];
        $price = $records[0]["price"];
        $category = $records[0]["category"];
        $detail = $records[0]["detail"];
        $product = new Product($id, $name, $price, $category, $detail);
    }
}catch (PDOException $e){
        echo $e->getMessage();
        die;
    }finally{
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
<main id="update">
	<h2>商品の更新</h2>
	<p class="note">商品名と価格は<em>必須入力</em>です。</p>
	<form class="update">
		<table class="form">
			<tr>
				<th>商品ID</th>
				<td>
					<input type="hidden" name="id" value="<?= $product-> getId() ?>" />
					<?= $product-> getId() ?>
				</td>
			</tr>
			<tr>
				<th>カテゴリ</th>
				<td>
					<select name="category">
					    <option value = "<?= $product-> getCategory() ?>" selected><?= $product-> getCategory() ?></option>
					    <option value="none" disabled>カテゴリーを選択してください</option>
						<option value="財布・小物入れ" >財布・小物入れ</option>
						<option value="食卓用">食卓用</option>
						<option value="その他" >その他</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>商品名</th>
				<td><input type="text" name="name" value="<?= $product-> getName() ?>"></td>
			</tr>
			<tr>
				<th>価格</th>
				<td><input type="number" name="price" value="<?= $product-> getPrice() ?>">円</td>
			</tr>
			<tr>
				<th>商品説明</th>
				<td><textarea name="detail" id="" cols="30" rows="3"><?= $product-> getDetail() ?></textarea></td>
			</tr>
			<tr class="buttons">
				<td colspan="2">
					<button formaction="confirm.php" formmethod="post" name="action" value="update">確認画面へ</button>
				</td>
			</tr>
		</table>
	</form>
</main>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>