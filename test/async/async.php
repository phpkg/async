<?php
/**
 * @author: Jackong
 * Date: 15/5/18
 * Time: 上午10:58
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/async/Async.php';

\pho\describe('Async', function () {
    $this->options = [
        'api' => 'http://localhost:8080',
        'sync' => true,
        'key' => 'abc',
        'payload' => [
            'iss' => 'http://facelike.com',
            'exp' => 5,
            'mid' => 222
        ]
    ];
    $this->async = new \async\Async($this->options);

    \pho\context('get', function () {
        \pho\it('should request with query', function () {
            $res = json_decode($this->async->get('/api.php', ['a' => 'b', 'b' => 'c']), true);
            \pho\expect($res['method'])
            ->toBe('GET');
            \pho\expect($res['params']['a'])
            ->toBe('b');
            \pho\expect($res['params']['b'])
                ->toBe('c');
            \pho\expect(str_replace('Bearer ', '', $res['authorization']))
                ->toBe(JWT::encode($this->options['payload'], $this->options['key']));
        });
    });

    \pho\context('post', function () {
        \pho\it('should request with data', function () {
            $res = json_decode($this->async->post('/api.php', ['a' => 'b', 'b' => 'c']), true);
            \pho\expect($res['method'])
                ->toBe('POST');
            \pho\expect($res['params']['a'])
                ->toBe('b');
            \pho\expect($res['params']['b'])
                ->toBe('c');
        });
    });

    \pho\context('put', function () {
        \pho\it('should request with data', function () {
            $res = json_decode($this->async->put('/api.php', ['a' => 'b', 'b' => 'c']), true);
            \pho\expect($res['method'])
                ->toBe('PUT');
            \pho\expect($res['params']['a'])
                ->toBe('b');
            \pho\expect($res['params']['b'])
                ->toBe('c');
        });
    });

    \pho\context('delete', function () {
        \pho\it('should request with data', function () {
            $res = json_decode($this->async->delete('/api.php', ['a' => 'b', 'b' => 'c']), true);
            \pho\expect($res['method'])
                ->toBe('DELETE');
            \pho\expect($res['params']['a'])
                ->toBe('b');
            \pho\expect($res['params']['b'])
                ->toBe('c');
        });
    });
});