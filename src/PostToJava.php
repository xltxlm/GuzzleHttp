<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53.
 */

namespace xltxlm\guzzlehttp;

use GuzzleHttp\Client;

/**
 * 不是表单形式的提交post变量,而是类似提交到java客户端
 * Class PostToJava.
 */
class PostToJava
{
    use HttpBase;
    protected $put = false;

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->put;
    }

    /**
     * @param bool $put
     * @return PostToJava
     */
    public function setPut(bool $put): PostToJava
    {
        $this->put = $put;
        return $this;
    }


    public function __invoke()
    {
        $client = new Client();
        $options =
            [
                'headers' => $this->getHeader(),
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->isDebug(),
                'auth' => [$this->getUser(), $this->getPasswd()],
                'body' => $this->getBody(),
            ];
        if ($this->isPut()) {
            $response = $client->put($this->getUrl(), $options);
        } else {
            $response = $client->post($this->getUrl(), $options);
        }
        return $response->getBody()->getContents();
    }
}
