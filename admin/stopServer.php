<?php

if (isset($_POST['stopServer'])) {
    ignore_user_abort(false);
    if (!file_exists('stop.txt')) {
        file_put_contents('stop.txt', "");
    }
}
