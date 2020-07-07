<?php
namespace xltxlm\guzzlehttp\Get;

/**
 * :类;
 * 提供get请求方式;
*/
abstract class Get_implements
{


/**
* @var \GuzzleHttp\Client $client  可以服用的tcp句柄
*  发送请求;
*  @return :string;
*/
abstract public function __invoke(\GuzzleHttp\Client $client = null):string;
}