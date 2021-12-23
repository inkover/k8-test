<?php

define('ROOT', dirname(__DIR__));
const APP_TYPE = 'www';
include ROOT . '/kernel.php';

function www_handlePost(): array {
    if (empty($_POST['code'])) {
        return ['', ''];
    }

    $error = sender_checkUserConfirmCoder($_POST['code']);
    if ($error) {
        return [$error, ''];
    }
    return ['', 'User confirmed!'];
}

function www_handleRequest() {
    reqLib('db/common');
    reqLib('sender/common');
    [$error, $success] = www_handlePost();
    ?>
    <html>
    <body>
        <h1>Confirm email</h1>
        <form method="post">
            <?=($error ? '<div style="color: red;">Error: ' . $error . '</div>' : '')?>
            <?=($success ? '<div style="color: green;">Success: ' . $success . '</div>' : '')?>
            Enter code from email: <br>
            <input type="text" name="code">
            <input type="submit" value="Confirm">
        </form>
    </body>
    </html>
<?php
}

boot();
