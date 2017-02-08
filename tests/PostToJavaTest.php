<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 11:51
 */

namespace xltxlm\guzzlehttp\tests;


use PHPUnit\Framework\TestCase;
use xltxlm\guzzlehttp\PostToJava;

class PostToJavaTest extends TestCase
{

    public function test()
    {
        echo (new PostToJava())
            ->setUrl("http://127.0.0.1/http200.php")
            ->setBody(__FILE__)
            ->__invoke();
    }
}