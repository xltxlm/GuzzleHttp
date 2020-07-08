<?php
header("hello:ok");
header("logid:" . uniqid());
/**
 * 给单元测试提供真实的模拟的测试接口
 */
if (isset($_GET['type']) && isset($_GET['key'])) {
    switch ($_GET['type']) {
        case 'get':
            echo $_GET[$_GET['key']];
            break;
        case 'post':
            echo $_POST[$_GET['key']];
            break;
    }
} elseif (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'get':
            echo json_encode($_GET, JSON_UNESCAPED_UNICODE);
            break;
        case 'post':
            echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
            break;
    }
}