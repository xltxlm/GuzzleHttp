<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:53
 */

namespace xltxlm\guzzlehttp;


use GuzzleHttp\Client;
use Psr\Log\LogLevel;
use xltxlm\logger\Grpclog\Grpclog;
use xltxlm\logger\Operation\Action\HttpLog;

class Post implements UrlRequest
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
        $Grpclog = (new Grpclog())
            ->setip($this->getUrl())
            ->setLogtype('POST');
        if ($client == null) {
            $client = new Client();
        }
        $this->options =
            [
                "headers" => $this->getHeader(),
                'timeout' => $this->getTimeout(),
                //不检查https证书的合法性
                'verify' => false,
                'debug' => $this->isDebug(),
                'auth' => [$this->getUser(), $this->getPasswd()],
                'form_params' => $this->getBody()
            ];

        $return_data = "";
        try {
            $response = $client->post($this->getUrl(), $this->options);
            $this->setReturnHeader($response->getHeaders());
            $return_data = $response->getBody()->getContents();
            $Grpclog
                ->setreturn_data($return_data);
        } catch (\Exception $e) {
            $Grpclog
                ->seterror("[POST]{$this->getUrl()} | " . $e->getMessage())
                ->__invoke();
            throw new \Exception("[POST]{$this->getUrl()} | " . $e->getMessage());
        }
        $Grpclog
            ->setrequest_data(json_encode($this->getOptions(), JSON_UNESCAPED_UNICODE))
            ->__invoke();
        unset($Grpclog);
        if ($this->getReturnToClass()) {
            $class = $this->getReturnToClass();
            $json_decode = json_decode($return_data, true);
            return $classObject = (new $class($json_decode));
        }

        return $return_data;
    }
}