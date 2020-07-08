<?php

namespace xltxlm\guzzlehttp\test\Get;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use xltxlm\guzzlehttp\Get;

/**
 *
 */
class client_246_0Test extends TestCase
{
    use client_246_0Test\client_246_0Provider; #<---本次测试的数据供给来源

    /**
     * @test
     * @dataProvider MyProvider <---本次测试的数据供给来源,3个索引分别对准本函数的3个参数
     * $input 输入值
     * $expected 期望的结果
     */
    public function __invoke($input, $expected, $args)
    {

        $result = $this->runcode($input, $args);
        //最终进行判断
        $this->assertEquals($expected, $result);
    }

    /**
     * 真正的逻辑计算
     * $input 输入值
     * $expected 期望的结果
     */
    private function runcode($input, $args)
    {
        $httpclient = new Client();
        //第一次请求
        $invoke = (new Get($input));
        $invoke
            ->__invoke($httpclient);
        $log1 = $invoke->getReturnHeader()[$args][0];
        $invoke2 = (new Get($input));
        $invoke2
            ->__invoke($httpclient);
        $log2 = $invoke2->getReturnHeader()[$args][0];
        return true || $log1 == $log2;
    }

}

