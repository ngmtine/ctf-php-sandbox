<?php
session_start();

// POST リクエストがある場合には、送信されたユーザー名とパスワードを検証する
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 仮にユーザー名が 'example'、パスワードが 'password' だとする
    $username = "example";
    $password = "password";

    if ($_POST["username"] === $username && $_POST["password"] === $password) {
        // ログインに成功した場合は、セッションにログイン状態を保持する
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit();
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
