<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/8
 * Time: 9:52
 */

namespace xltxlm\guzzlehttp;

/**
 * 网址接口请求的基本元素
 * Class HttpBase
 * @package xltxlm\guzzlehttp
 */
trait HttpBase
{
    /** @var string 网址 */
    protected $url = "";
    /** @var string 提交的参数 */
    protected $body = "";
    /** @var int 超时设置 */
    protected $timeOut = 6;
    /** @var string 是否发送 referer */
    protected $referer = true;
    /** @var array 请求头 */
    protected $header = [];

    /** @var bool */
    protected $debug = false;

    /** @var string 开启http认证的账户 */
    protected $user = "";
    /** @var string 开启http认证的密码 */
    protected $passwd = "";

    protected $options = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options + ['url' => $this->getUrl()];
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return static
     */
    public function setUser(string $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     * @return static
     */
    public function setPasswd(string $passwd)
    {
        $this->passwd = $passwd;
        return $this;
    }

    /**
     * HttpBase constructor.
     * @param string $url
     */
    public function __construct($url = "")
    {
        $this->setUrl($url);
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return static
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return static
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     * @return static
     */
    public function setTimeOut(int $timeOut)
    {
        $this->timeOut = $timeOut;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return static
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
        return $this;
    }


    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     * @param string $word
     * @return static
     */
    public function setHeader($header, $word)
    {
        $this->header[$header] = $word;
        return $this;
    }


    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     * @return static
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        //是否加上来源设置
        if ($this->referer === true) {
            $this->setHeader('Referer', $this->url);
        } elseif ($this->referer) {
            $this->setHeader('Referer', $this->referer);
        }

        return $this;
    }


}