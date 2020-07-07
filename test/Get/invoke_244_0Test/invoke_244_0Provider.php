<?php
namespace xltxlm\guzzlehttp\test\Get\invoke_244_0Test;

/**
* 测试案例的数据供给
*/
Trait invoke_244_0Provider {

    /**
     * 测试的数据供给器
     */
    public function MyProvider(){
        return [
        ["http://127.0.0.1:8088/a.php","",null,"返回状态是404"],
        ]+ $this->remoteconfig();
    }

    /**
     * 获取远程配置代码。
     * 因为是远程获取配置的原因，所以传递过去一定是字符串
     */
    function remoteconfig()
    {
        $config = [];
        return $config;
    }
}

