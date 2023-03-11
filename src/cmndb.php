<?php

class DbAccess
{
    public function __construct()
    {
        // コンストラクタ
    }

    private $_pdo; // PDO
    private $_stmt; // PDOStatement
    const SUCCESS = 0;
    const ERROR = -1;

    public function connect()
    {
        // db接続

        // ホスト名はdocker-compose.yamlのservicesに付けた名前を指定
        $dsn = "pgsql:dbname=main;host=db;port=5432";
        $user = "dockeruser";
        $pass = "dockerpass";

        $this->_pdo = new PDO($dsn, $user, $pass);

        // pdoがエラーを検出した時に例外を投げるための設定
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return self::ERROR;
        }

        return self::SUCCESS;
    }

    public function disconnect()
    {
        // db切断

        $this->_pdo = null;
        return self::SUCCESS;
    }

    public function query($sql, $param = null)
    {
        // sql実行

        try {
            if (!isset($param)) {
                $this->_stmt = $this->_pdo->query($sql);
            } else {
                $this->_stmt = $this->_pdo->prepare($sql);
                $this->_stmt->execute($param);
            }
        } catch (PDOException $e) {
            return [self::ERROR, $this->_stmt];
        }

        return [self::SUCCESS, $this->_stmt];
    }

    public function beginTransaction()
    {
        // トランザクション開始

        try {
            $this->_pdo->beginTransaction();
        } catch (PDOException $e) {
            return self::ERROR;
        }

        return self::SUCCESS;
    }

    public function commit()
    {
        // コミット

        try {
            $this->_pdo->commit();
        } catch (PDOException $e) {
            return self::ERROR;
        }

        return self::SUCCESS;
    }

    public function rollback()
    {
        // ロールバック

        try {
            $this->_pdo->rollBack();
        } catch (PDOException $e) {
            return self::ERROR;
        }

        return self::SUCCESS;
    }
}

?>
