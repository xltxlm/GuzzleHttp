<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/10/11
 * Time: 17:32
 */

namespace xltxlm\allinone\vendor\xltxlm\guzzlehttp\src;


use GuzzleHttp\Client;
use xltxlm\guzzlehttp\HttpBase;
use xltxlm\logger\Operation\Action\HttpLog;

class Delete
{
    use HttpBase;

    public function __invoke()
    {
        $start = microtime(true);
        $client = new Client();
        $this->options =
            [
                "headers" => $this->getHeader(),
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->isDebug(),
                'auth' => [$this->getUser(), $this->getPasswd()],
                'body' => $this->getBody()
            ];

        $response = $client->delete($this->getUrl(), $this->options);
        $time = sprintf('%.4f', microtime(true) - $start);
        (new HttpLog($this))
            ->setRunTime($time)
            ->__invoke();
        return $response->getBody()->getContents();
    }
}