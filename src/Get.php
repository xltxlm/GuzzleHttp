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
class Get implements UrlRequest
{
    use HttpBase;

    /**
     * 如果传递了请求实例进来,那么可以变成keep-Alive长连接
     * @param Client|null $client
     * @return string
     * @throws \Exception
     */
    public function __invoke(Client $client = null)
    {
        $httpLog = (new HttpLog($this))
            ->setUrl($this->getUrl())
            ->setSqlaction('GET');
        if ($client == null) {
            $client = new Client();
        }
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

        $return_data = '';
        try {
            $response = $client->get($this->getUrl(), $this->options);
            $return_data = $response->getBody()->getContents();
            $this->setReturnHeader($response->getHeaders());
            $httpLog
                ->setMessage($return_data);
        } catch (\Exception $e) {
            $httpLog
                ->setException("[GET]{$this->getUrl()} | " . $e->getMessage())
                ->__invoke();
            unset($httpLog);
            throw new \Exception("[GET]{$this->getUrl()} | " . $e->getMessage());
        }
        $httpLog
            ->setPdoSql(json_encode($this->getOptions(), JSON_UNESCAPED_UNICODE))
            ->__invoke();
        unset($httpLog);
        return $return_data;
    }
}
