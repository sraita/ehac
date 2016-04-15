<?php

/**
 * PHP SDK for WEIBO MessageClient
 *
 * @package   WEIBO MessageClient
 * @author    Ding Jiao <ding.jiao@gmail.com>
 */
class MessageClient implements Iterator {

    protected $_host = '';
    protected $_request = "";
    protected $_socket;
    protected $_port = 80;
    protected $_ftimeout = 30;
    protected $_timeout = 300;
    protected $_key = 0;
    protected $_value = '';
    protected $_httpauth = '';

    public function __construct($args, $url, $user, $passwd) {
        $parse = parse_url($url);
        $this->_host = $parse['host'];
        $this->_port = isset($parse['port']) ? $parse['port'] : 80;
        $path = $parse['path'];
        $query = http_build_query($args);
        $this->_httpauth = base64_encode($user . ":" . $passwd);
        $this->_request = $path . '?' . $query;
    }

    public function __destruct() {
        $this->close();
    }

    public function current() {
        return $this->_value;
    }

    public function key() {
        return $this->_key;
    }

    public function next() {
        ++$this->_key;
    }

    public function rewind() {
        $this->close();
        $this->_key = $err_no = 0;
        $this->_value = $err_str = '';
        $this->_socket = @fsockopen($this->_host, $this->_port, $err_no, $err_str, $this->_ftimeout);
        if ($this->_socket) {
            stream_set_timeout($this->_socket, $this->_timeout);
            stream_set_blocking($this->_socket, 1);
            $header = "GET " . $this->_request . " HTTP/1.1\r\n";
            $header .= "Host: " . $this->_host . "\r\n";
            $header .= "Authorization:Basic {$this->_httpauth}\r\n";
            $header .= "Connection: Close\r\n\r\n";

            fwrite($this->_socket, $header);
            do {
                $data = fgets($this->_socket);
            } while (trim($data));
        }
    }

    public function valid() {
        $eof = true;
        if (is_resource($this->_socket)) {
            do {
                $eof = feof($this->_socket);
                $this->_value = json_decode(trim(fgets($this->_socket)), true);
            } while (!$eof && !is_array($this->_value));
            $eof && $this->close();
        }
        return !$eof;
    }

    private function close() {
        if (is_resource($this->_socket)) {
            fclose($this->_socket);
            $this->_socket = null;
        }
        return true;
    }

    public static function httpPost($args, $url, $user, $passwd, $timeout = 30) {
        $postdata = http_build_query($args);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $passwd);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}