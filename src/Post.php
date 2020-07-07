<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\LoggerTrack;

class Post implements UrlRequest
{
    use HttpBase;

    /**
     * 如果传递了请求实例进来,那么可以变成keep-Alive长连接
     *
     * @param Client|null $client
     * @return string
     * @throws \Exception
     */
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
                'form_params' => $this->getBody()
            ];
        $context = [
            'type' => __CLASS__,
            'options' => $this->options
        ];
        $LoggerTrack = (new LoggerTrack())
            ->setresource_type('http')
            ->setcontext($context);

        if ($client == null) {
            $client = new Client();
        }

        $return_data = "";
        try {
            $response = $client->post($this->getUrl(), $this->options);
            $this->setReturnHeader($response->getHeaders());
            $return_data = $response->getBody()->getContents();
            $LoggerTrack
                ->setcontext( ['return_data' => $return_data]);
        } catch (\Exception $e) {
            $LoggerTrack
                ->setcontext(['exception' => "[POST]{$this->getUrl()} | " . $e->getMessage()])
                ->__invoke();
            throw new \Exception("[POST]{$this->getUrl()} | " . $e->getMessage());
        }
        $LoggerTrack->__invoke();
        if ($this->getReturnToClass()) {
            $class = $this->getReturnToClass();
            $json_decode = json_decode($return_data, true);
            return $classObject = (new $class($json_decode));
        }

        return $return_data;
    }
}