<?php
session_start();
require_once "cmndb.php";

function auth_login($username, $password)
{
    # DB接続
    $dbaccess = new DbAccess();
    if ($dbaccess->connect() === -1) {
        return false;
    }

    # ユーザ認証クエリ
    $query_str = "
        SELECT count(id) FROM users WHERE username = '{$username}' AND password_hash = crypt('{$password}', password_hash);
    ";

    # sql実行
    list($stat, $stmt) = $dbaccess->query($query_str);
    if ($stat === -1) {
        return false;
    }

    # DB切断
    $dbaccess->disconnect();

    # 認証されたならtrue, 失敗でfalse
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result[0]["count"] === 1) {
        return true;
    } else {
        return false;
    }
}

// POST リクエストがある場合には、送信されたユーザー名とパスワードを検証する
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = auth_login($username, $password);
    if ($result) {
        // ログインに成功した場合は、セッションにログイン状態を保持する
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit();
        // $error = "ログイン成功！";
    } else {
        // ログインに失敗した場合はエラーメッセージを表示する
        $error = "ユーザー名またはパスワードが違います";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">ユーザー名：</label>
        <input type="text" id="username" name="username"><br>

        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password"><br>

        <input type="submit" value="ログイン">
    </form>
</body>
</html>
