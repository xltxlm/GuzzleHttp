<?php

namespace xltxlm\guzzlehttp\test\Get;

use PHPUnit\Framework\TestCase;
use xltxlm\guzzlehttp\Get;

/**
 *
 */
class invoke_244_0Test extends TestCase
{
    use invoke_244_0Test\invoke_244_0Provider; #<---本次测试的数据供给来源

    /**
     * @test
     * @dataProvider MyProvider <---本次测试的数据供给来源,3个索引分别对准本函数的3个参数
     * $input 输入值
     * $expected 期望的结果
     */
    public function __invoke($input, $expected, $args)
    {
        $this->expectException(\Exception::class); #<-----------这个测试比较奇葩，要验证是不是有异常

        $result = $this->runcode($input, $args);
    }

    /**
     * 真正的逻辑计算
     * $input 输入值
     * $expected 期望的结果
     */
    private function runcode($input, $args)
    {
        $invoke = (new Get($input))
            ->__invoke();
        return $invoke;
    }

}

