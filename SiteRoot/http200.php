<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 10:16
 */
echo "<pre>-->";
print_r($_POST);
echo "<--@in ".__FILE__." on line ".__LINE__."\n";
echo "<pre>-->";
print_r(file_get_contents("php://input"));
echo "<--@in ".__FILE__." on line ".__LINE__."\n";