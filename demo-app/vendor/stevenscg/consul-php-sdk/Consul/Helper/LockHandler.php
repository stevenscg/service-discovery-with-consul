<?php

namespace SensioLabs\Consul\Helper;

use SensioLabs\Consul\Services\KV;
use SensioLabs\Consul\Services\Session;

class LockHandler
{
    private $key;
    private $value;
    private $session;
    private $kv;

    private $sessionId;

    public function __construct($key, $value = null, Session $session = null, KV $kv = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->session = $session ?: new Session();
        $this->kv = $kv ?: new KV();
    }

    public function lock()
    {
        // Start a session
        $results         = $this->session->create();
        $this->sessionId = json_decode($results->getBody(), true)['ID'];

        // Lock a key / value with the current session
        $results      = $this->kv->put($this->key, (string) $this->value, ['acquire' => $this->sessionId]);
        $lockAcquired = json_decode($results->getBody(), true);

        if (false === $lockAcquired) {
            $this->session->destroy($this->sessionId);

            return false;
        }

        register_shutdown_function(array($this, 'release'));

        return true;
    }

    public function release()
    {
        $this->kv->delete($this->key);
        $this->session->destroy($this->sessionId);
    }
}
