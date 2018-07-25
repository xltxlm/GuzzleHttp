<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2018/6/8
 * Time: 上午11:34
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;

class Head implements UrlRequest
{
    use HttpBase;

    /**
     * @return \string[][]
     */
    public function __invoke()
    {
        $client = new Client();
        $this->options =
            [
                'allow_redirects'=>$this->isAllowRedirects(),
                "headers" => $this->header,
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->debug,
                'auth' => [$this->getUser(), $this->getPasswd()],
                'body' => $this->getBody(),
                'proxy' => $this->getProxy()
            ];
        $response = $client->head($this->getUrl(), $this->options);
        $this->setReturnHeader($response->getHeaders());
        return $response->getHeaders();
    }

}