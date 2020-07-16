<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53.
 */

namespace xltxlm\guzzlehttp;

use GuzzleHttp\Client;
use xltxlm\logger\LoggerTrack;

/**
 * 不是表单形式的提交post变量,而是类似提交到java客户端
 * Class PostToJava.
 */
class PostToJava implements UrlRequest
{
    use HttpBase;

    public function __invoke(Client $client = null)
    {
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
        $context = [
            'type' => __CLASS__,
            'url' => $this->getUrl(),
            'options' => $this->options
        ];

        $LoggerTrack = (new LoggerTrack())
            ->setresource_type('http')
            ->setcontext($context);

        if ($client == null) {
            $client = new Client();
        }
        try {
            $response = $client->post($this->getUrl(), $this->options);
            $return_data = $response->getBody()->getContents();
            $LoggerTrack
                ->setcontext( ['return_data' => $return_data]);
        } catch (\Exception $e) {
            $LoggerTrack
                ->setcontext( ['exception' => "[POST-JAVA]{$this->getUrl()} | " . $e->getMessage()])
                ->__invoke();
            throw new \Exception("[POST-JAVA]{$this->getUrl()} | " . $e->getMessage());
        }
        $LoggerTrack->__invoke();
        if ($this->getReturnToClass()) {
            $class = $this->getReturnToClass();
            $json_decode = json_decode($response->getBody()->getContents(), true);
            return $classObject = (new $class($json_decode));
        }
        return $return_data;
    }
}
