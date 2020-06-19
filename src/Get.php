<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:52
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\LoggerTrack;

/**
 * Class Get
 *
 * @package xltxlm\guzzlehttp
 */
class Get implements UrlRequest
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
                'allow_redirects' => $this->isAllowRedirects(),
                "headers" => $this->header,
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->debug,
                'auth' => [$this->getUser(), $this->getPasswd()],
                'body' => $this->getBody(),
                'proxy' => $this->getProxy()
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
        $return_data = '';
        try {
            $response = $client->get($this->getUrl(), $this->options);
            $return_data = $response->getBody()->getContents();
            $this->setReturnHeader($response->getHeaders());
            $LoggerTrack
                ->setcontext($context + ['return_data' => $return_data]);
        } catch (\Exception $e) {
            $LoggerTrack
                ->setcontext($context + ['exception' => "[GET]{$this->getUrl()} | " . $e->getMessage()]);
            $LoggerTrack->__invoke();
            throw new \Exception("[GET]{$this->getUrl()} (proxy:{$this->getProxy()}) | " . $e->getMessage());
        }
        $LoggerTrack->__invoke();
        return $return_data;
    }
}
