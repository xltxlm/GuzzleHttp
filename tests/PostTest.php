<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 11:41
 */

namespace xltxlm\guzzlehttp\tests;


use PHPUnit\Framework\TestCase;
use xltxlm\guzzlehttp\Post;

class PostTest extends TestCase
{

    public function test200()
    {
        echo (new Post())
            ->setUrl("http://127.0.0.1/http200.php")
            ->setBody(['name' => __FILE__])
            ->__invoke();
    }
}