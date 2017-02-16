<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:52
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;

/**
 * Class Get
 * @package xltxlm\guzzlehttp
 */
class Get
{
    use HttpBase;

    public function __invoke()
    {
        $client = new Client();
        $options =
            [
                "headers" => $this->header,
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->debug,
                'body' => $this->getBody(),
            ];

        $response = $client->get($this->getUrl(), $options);
        return $response->getBody()->getContents();
    }
}
