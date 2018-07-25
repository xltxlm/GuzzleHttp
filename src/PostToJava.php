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
class PostToJava implements UrlRequest
{
    use HttpBase;

    public function __invoke()
    {
        $httpLog = (new HttpLog($this))
            ->setSqlaction('POSTJAVA');
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

        try {
            $response = $client->post($this->getUrl(), $this->options);
        } catch (\Exception $e) {
            throw new \Exception("[POST-JAVA]{$this->getUrl()} | " . $e->getMessage());
        }
        $httpLog
            ->setMessage($this->options)
            ->__invoke();
        if ($this->getReturnToClass()) {
            $class = $this->getReturnToClass();
            $json_decode = json_decode($response->getBody()->getContents(), true);
            return $classObject = (new $class($json_decode));
        }
        return $response->getBody()->getContents();
    }
}
