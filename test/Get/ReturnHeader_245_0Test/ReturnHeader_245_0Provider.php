<?php
namespace xltxlm\guzzlehttp\test\Get\ReturnHeader_245_0Test;

/**
* 测试案例的数据供给
*/
Trait ReturnHeader_245_0Provider {

    /**
     * 测试的数据供给器
     */
    public function MyProvider(){
        return [
        ["http://127.0.0.1:8088/index.php?type=get&key=a&a=ok","ok","hello","观察http的返回头"],
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

