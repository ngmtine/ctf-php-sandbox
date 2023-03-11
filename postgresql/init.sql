CREATE EXTENSION pgcrypto
;

CREATE TABLE
    users (
        id SERIAL PRIMARY KEY,
        username TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL
    )
;

INSERT INTO
    users
VALUES
    (
        1,
        'testuser',
        crypt ('password', gen_salt ('md5'))
    )
;