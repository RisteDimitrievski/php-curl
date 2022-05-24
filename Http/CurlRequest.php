<?php
namespace curl\Http;

/**
 * Class CurlRequest
 * @package curl\Http
 * @author Riste Dimitrievski < riste@ristedimitrievski.mk >
 * @version 1.0
 * @property $url;
 * @property $headers;
 * @property $options
 * @property $responseData;
 * @property $responseCode;
 * @property $ch;
 */
Abstract class CurlRequest implements Linkable
{
    public function __construct(string $url, array $headers, array $options)
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->options = $options;
        $this->ch = curl_init();
    }
    public function setUrl()
    {
        curl_setopt($this->ch,CURLOPT_URL,$this->url);
    }
    public function setHeaders()
    {
        if(isset($this->headers))
        {
            if(!is_array($this->headers))
            {
                return new \Exception("Headers parameter expects array data, string/object provided");
            }
            curl_setopt($this->ch,CURLOPT_HTTPHEADER,$this->headers);
        }
    }
    public function setOptions()
    {
        if(isset($this->options))
        {
            if(!is_array($this->options))
            {
                return new \Exception("Curl Options expects array data, string/object provided");
            }
            foreach($this->options as $key => $value)
            {
                if(is_string($key))
                {
                    return new \Exception("Curl options should be compatible with curl_setopt constants, string provided. {$key}");
                }
            }
            curl_setopt_array($this->ch,$this->options);
        }
    }
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    public function setResponseCode(int $code)
    {
        $this->responseCode = $code;
    }
    public function getResponse()
    {
        return $this->responseData;
    }
    public function setResponse($data)
    {
        $this->responseData = $data;
    }

    public function run()
    {
        $this->setUrl();
        $this->setHeaders();
        $this->setOptions();
        $this->setResponse(curl_exec($this->ch));
        $this->setResponseCode(curl_getinfo($this->ch,CURLINFO_HTTP_CODE));
        curl_close($this->ch);
    }
}