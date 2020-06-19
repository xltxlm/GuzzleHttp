<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/10/11
 * Time: 17:32
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\LoggerTrack;

class Delete implements UrlRequest
{
    use HttpBase;

    public function __invoke()
    {
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


        $LoggerTrack = (new LoggerTrack())
            ->setresource_type('http')
            ->setcontext([
                'type' => __CLASS__,
                'options' => $this->options
            ]);
        $client = new Client();

        try {
            $response = $client->delete($this->getUrl(), $this->options);
        } catch (\Exception $e) {
            throw new \Exception("[DELETE]{$this->getUrl()} | " . $e->getMessage());
        }
        $LoggerTrack
            ->__invoke();
        return $response->getBody()->getContents();
    }
}