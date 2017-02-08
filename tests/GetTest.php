<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 10:17
 */

namespace xltxlm\guzzlehttp\tests;


use PHPUnit\Framework\TestCase;
use xltxlm\guzzlehttp\Get;

class GetTest extends TestCase
{

    public function test200()
    {
        (new Get())
            ->setUrl("http://127.0.0.1/http200.php")
            ->__invoke();
    }

    /**
     * @expectedException \Exception
     */
    public function test404()
    {
        (new Get())
            ->setUrl("http://127.0.0.1/http404.php")
            ->__invoke();
    }

    /**
     * @expectedException \Exception
     */
    public function test502()
    {
        (new Get())
            ->setUrl("http://127.0.0.1/http502.php")
            ->__invoke();
    }
}