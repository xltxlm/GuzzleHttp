<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;

class Post
{
    use HttpBase;

    public function __invoke()
    {
        $client = new Client();
        $options =
            [
                "headers" => $this->getHeader(),
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->isDebug(),
                'auth' => [$this->getUser(), $this->getPasswd()],
                'form_params' => $this->getBody()
            ];

        $response = $client->post($this->getUrl(), $options);
        return $response->getBody()->getContents();
    }
}