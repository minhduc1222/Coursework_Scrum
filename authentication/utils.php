<?php
function respond($success, $message, $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit();
}

function generateToken($length = 20) {
    return bin2hex(random_bytes($length));
}
?>
