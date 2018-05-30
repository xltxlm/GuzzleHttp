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

class Post implements UrlRequest
{
    use HttpBase;

    public function __invoke()
    {
        $httpLog = (new HttpLog($this))
            ->setSqlaction('POST');
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
        $httpLog
            ->setMessage($this->getOptions())
            ->__invoke();

        if ($this->getReturnToClass()) {
            $class = $this->getReturnToClass();
            $json_decode = json_decode($response->getBody()->getContents(), true);
            return $classObject = (new $class($json_decode));
        }

        return $response->getBody()->getContents();
    }
}