<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:52
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use xltxlm\logger\Grpclog\Grpclog;
use xltxlm\logger\Operation\Action\HttpLog;

/**
 * Class Get
 * @package xltxlm\guzzlehttp
 */
class Get implements UrlRequest
{
    use HttpBase;


    public function __invoke()
    {
        $Grpclog = (new Grpclog())
            ->setip($this->getUrl())
            ->setLogtype('GET');
        $client = new Client();
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
            $Grpclog
                ->setreturn_data($return_data);
        } catch (\Exception $e) {
            $Grpclog
                ->seterror("[GET]{$this->getUrl()} | " . $e->getMessage())
                ->__invoke();
            throw new \Exception("[GET]{$this->getUrl()} | " . $e->getMessage());
        }
        unset($Grpclog);
        return $return_data;
    }
}
