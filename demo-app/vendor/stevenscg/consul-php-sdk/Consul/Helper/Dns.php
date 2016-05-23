<?php

namespace SensioLabs\Consul\Helper;

class Dns
{
    private $retries = 3;
    private $backoff = 50; // microseconds ** $i

    /**
     * Returns the first DNS SRV record from the local DNS
     * server managed by consul. The returned value is
     * load-balanced in real-time and should not be cached.
     *
     * @see http://php.net/manual/en/function.dns-get-record.php
     * @param string $name The consul dns name for the service.
     * @return array The first SRV record from dns_get_record, false otherwise.
     */
    public function srv($name)
    {
        $i = 0;
        do {
            // Apply a simple exponential backoff.
            // @TODO add some jitter.
            if ($i > 0) {
                usleep($this->backoff ** $i);
            }
            $srv = dns_get_record($name, DNS_SRV);
            $i++;
        } while (empty($srv) && ($i < $this->retries));

        if (empty($srv)) {
            return false;
        }

        return $srv[0];
    }


    /**
     * Returns the fully-qualified http/https service
     * url from the DNS managed by consul. The returned
     * value is load-balanced in real-time and should
     * not be cached.
     *
     * @param string $name The name of the service.
     * @param string $proto The protocol to be used.
     * @return string url on success, false otherwise.
     */
    public function url($name, $proto = 'http')
    {
        $host = $this->srv($name);
        if (empty($host['target'])) {
            return false;
        }

        $url = '';
        if (!empty($proto)) {
            $url .= $proto . '://';
        }
        $url .= $host['target'];
        if (!empty($host['port'])) {
            $url .= ':'. $host['port'];
        }

        return $url;
    }
}
