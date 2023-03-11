<!DOCTYPE html>
<html>
    <head>
        <title>ログインページ</title>
    </head>

    <body>
        <h1>ログインしてください</h1>
        <?php if (isset($message)) {
            echo "<p>" . $message . "</p>";
        } ?>
        <form action="login.php" method="post">
            <label for="username">ユーザー名：</label>
            <input type="text" id="username" name="username" required /><br /><br />
            <label for="password">パスワード：</label>
            <input type="password" id="password" name="password" required /><br /><br />
            <input type="submit" value="ログイン" />
        </form>
    </body>
</html>
