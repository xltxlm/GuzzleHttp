<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/10/11
 * Time: 17:32
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\Operation\Action\HttpLog;

class Put implements UrlRequest
{
    use HttpBase;

    public function __invoke()
    {
        $httpLog = (new HttpLog($this))
            ->setSqlaction('PUT');
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
            $response = $client->put($this->getUrl(), $this->options);
        } catch (\Exception $e) {
            throw new \Exception("[PUT]{$this->getUrl()} | " . $e->getMessage());
        }
        $httpLog
            ->__invoke();
        return $response->getBody()->getContents();
    }
}