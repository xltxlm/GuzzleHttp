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
use xltxlm\guzzlehttp\UrlRequest;
use xltxlm\logger\Operation\Action\HttpLog;

class Delete implements UrlRequest
{
    use HttpBase;

    public function __invoke()
    {
        $httpLog = (new HttpLog($this))
            ->setSqlaction('DELETE');
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

        try {
            $response = $client->delete($this->getUrl(), $this->options);
        } catch (\Exception $e) {
            throw new \Exception("[DELETE]{$this->getUrl()} | ".$e->getMessage());
        }
        $httpLog
            ->__invoke();
        return $response->getBody()->getContents();
    }
}