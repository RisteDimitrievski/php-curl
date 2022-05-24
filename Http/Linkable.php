<?php
namespace curl\Http;
interface Linkable
{
    public function __construct(string $url, array $headers, array $options);
    public function setUrl();
    public function setHeaders();
    public function setOptions();
    public function run();
    public function getResponseCode();
    public function getResponse();
    public function setResponseCode(int $code);
    public function setResponse($data);
}