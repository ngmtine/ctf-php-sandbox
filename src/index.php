<?php
session_start();
// session_start() は、セッションを作成します。 もしくは、リクエスト上で GET, POST またはクッキーにより渡されたセッション ID に基づき現在のセッションを復帰します。

// session_status()
// セッションが無効な場合は PHP_SESSION_DISABLED
// セッションが有効だけれどもセッションが存在しない場合は PHP_SESSION_NONE
// セッションが有効で、かつセッションが存在する場合は PHP_SESSION_ACTIVE

// このindex.phpにアクセスした際、$_SESSION["loggedin"] がセットされていなければ、login.phpに遷移させる処理
if (!isset($_SESSION["loggedin"])) {
    // isset(): bool 変数がセットされているかをboolで返す関数

    // $_SESSION
    // 現在のスクリプトで使用できるセッション変数を含む連想配列です。
    // これは 'スーパーグローバル' あるいは自動グローバル変数と呼ばれるものです。 スクリプト全体を通してすべてのスコープで使用することができます。 関数やメソッドの内部で使用する場合にも global $variable; とする必要はありません。

    header("Location: login.php");
    // header(string $header, bool $replace = true, int $response_code = 0): void
    // header() は、生の HTTP ヘッダを送信する関数
    // $header 文字列には特別な物があり、例えば上記のような"Location"ヘッダは、ブラウザに REDIRECT (302) ステータスコードを返すことでリダイレクトさせることができる
    exit();
}

// ログイン後の処理を記述する
echo "ログインに成功しました！";
