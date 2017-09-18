<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:52
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\Operation\Action\HttpLog;

/**
 * Class Get
 * @package xltxlm\guzzlehttp
 */
class Get
{
    use HttpBase;


    public function __invoke()
    {
        $start = microtime(true);
        $client = new Client();
        $this->options =
            [
                "headers" => $this->header,
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->debug,
                'auth' => [$this->getUser(), $this->getPasswd()],
                'body' => $this->getBody(),
                'proxy' => $this->getProxy()
            ];

        $response = $client->get($this->getUrl(), $this->options);
        $time = sprintf('%.4f', microtime(true) - $start);
        (new HttpLog($this))
            ->setRunTime($time)
            ->__invoke();
        return $response->getBody()->getContents();
    }
}
