<?php
/**
 * @author: Jackong
 * Date: 15/5/18
 * Time: 上午10:59
 */

namespace async;

class Async {
    private $options = null;

    /**
     * @param $options
     */
    public function __construct($options) {
        $this->options = $options;
    }

    public function get($url, $params = [], $headers = []) {
        return $this->exec('GET', $url, $params, $headers);
    }

    public function post($url, $params = [], $headers = []) {
        return $this->exec('POST', $url, $params, $headers);
    }

    public function put($url, $params = [], $headers = []) {
        return $this->exec('PUT', $url, $params, $headers);
    }

    public function patch($url, $params = [], $headers = []) {
        return $this->exec('PATCH', $url, $params, $headers);
    }

    public function delete($url, $params = [], $headers = []) {
        return $this->exec('DELETE', $url, $params, $headers);
    }

    public function exec($method, $url, $params = [], $headers = []) {
        $tmp1 = [];
        foreach ($params as $key => $value) {
            $tmp1[] = "$key=$value";
        }
        $params = implode('&', $tmp1);

        $headers['Authorization'] = sprintf('Bearer %s', \JWT::encode(array_merge($this->options['payload']), $this->options['key']));
        $tmp2 = [];
        foreach ($headers as $key => $value) {
            $tmp2[] = sprintf('-H "%s: %s"', $key, $value);
        }
        $headers = implode(' ', $tmp2);

        $async = $this->options['sync'] ? '' : '>/dev/null 2>&1 &';
        if ($method === 'GET') {
            $cmd = sprintf('curl -X %s %s "%s%s?%s" %s', $method, $headers, $this->options['api'], $url, $params, $async);
        } else {
            $cmd = sprintf('curl -X %s %s --data "%s" "%s%s" %s', $method, $headers, $params, $this->options['api'], $url, $async);
        }
        var_dump($cmd);
        return shell_exec($cmd);
    }
} 