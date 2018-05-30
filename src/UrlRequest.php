<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2018/5/19
 * Time: 下午7:19
 */

namespace xltxlm\guzzlehttp;


interface UrlRequest
{
    public function getUrl(): string;
    public function getBody();
}