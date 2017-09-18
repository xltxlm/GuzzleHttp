<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\Operation\Action\HttpLog;

class Post
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
                'form_params' => $this->getBody()
            ];

        $response = $client->post($this->getUrl(), $this->options);
        $time = sprintf('%.4f', microtime(true) - $start);
        (new HttpLog($this))
            ->setRunTime($time)
            ->__invoke();
        return $response->getBody()->getContents();
    }
}