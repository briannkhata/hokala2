<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Curl 
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function create($url)
    {
        $this->CI->curl->create($url);
    }

    public function option($option, $value)
    {
        $this->CI->curl->option($option, $value);
    }

    public function http_header($header)
    {
        $this->CI->curl->http_header($header);
    }

    public function execute()
    {
        return $this->CI->curl->execute();
    }

    public function error()
    {
        return $this->CI->curl->error;
    }

    public function error_message()
    {
        return $this->CI->curl->error_message;
    }
}
