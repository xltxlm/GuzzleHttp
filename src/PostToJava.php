<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53.
 */

namespace xltxlm\guzzlehttp;

use GuzzleHttp\Client;
use xltxlm\logger\Operation\Action\HttpLog;

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
        $start = microtime(true);
        $client = new Client();
        $this->options =
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
            $response = $client->put($this->getUrl(), $this->options);
        } else {
            $response = $client->post($this->getUrl(), $this->options);
        }
        $time = sprintf('%.4f', microtime(true) - $start);
        (new HttpLog($this))
            ->setRunTime($time)
            ->__invoke();
        return $response->getBody()->getContents();
    }
}
