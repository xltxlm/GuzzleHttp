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

class Put implements UrlRequest
{
    use HttpBase;

    public function __invoke(Client $client = null)
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
        $context = [
            'type' => __CLASS__,
            'url' => $this->getUrl(),
            'options' => $this->options
        ];

        $LoggerTrack = (new LoggerTrack())
            ->setresource_type('http')
            ->setcontext($context);

        if ($client == null) {
            $client = new Client();
        }
        try {
            $response = $client->put($this->getUrl(), $this->options);
            $return_data = $response->getBody()->getContents();
            $LoggerTrack
                ->setcontext(['return_data' => $return_data]);
        } catch (\Exception $e) {
            $LoggerTrack
                ->setcontext(['exception' => "[PUT]{$this->getUrl()} | " . $e->getMessage()])
                ->__invoke();
            throw new \Exception("[PUT]{$this->getUrl()} | " . $e->getMessage());
        }
        $LoggerTrack
            ->__invoke();
        return $return_data;
    }
}