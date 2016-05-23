<?php

namespace SensioLabs\Consul\Helper;

use SensioLabs\Consul\Services\KV;

use SensioLabs\Consul\Exception\ClientException;
use SensioLabs\Consul\Exception\ServerException;


/**
 * This class implements a feature flagging system using Consul.
 *
 * This system is anonymous in that it has no knowledge of a particular
 * user, owner, or recipient of the feature.
 *
 * The methods within this helper return the response types specified
 * with each method vs the raw Guzzle response which is standard
 * elsewhere in this SDK.
 *
 * All feature records are json encoded objects with a simple structure:
 *   - name (string)  optional readable name for display
 *   - on   (boolean) true when feature is active (default: false)
 *   - v    (intger)  version of the structure (default: 1)
 *   - t    (integer) last modified (or created) unix timestamp
 *
 */
class Feature
{
    private $kv;
    private $base;

    public function __construct($base = 'feature', KV $kv = null)
    {
        $this->base = $base;
        $this->kv   = $kv ?: new KV();
    }


    /**
     * Determines whether the feature is enabled.
     * This method should be the main interface to the feature system
     * for client applications.
     *
     * @param string $key
     * @param boolean $default
     * @return boolean true if the feature is enabled, false otherwise
     */
    public function toggle($key, $default = false)
    {
        $feature = $this->get($key);

        // This handles the key not found
        if (empty($feature)) {
            return $default;
        }

        // Decode the first returned feature (there should only be one)
        $decoded = $this->decode($feature[0]);
        return !empty($decoded['on']) ? true : false;
    }


    /**
     * Returns the features for the supplied key or all keys under a given prefix.
     *
     * @param string $key
     * @param boolean $recurse
     * @return array of kv objects on success, false on failure
     */
    public function get($key = null, $recurse = null)
    {
        $options = [];
        if ($recurse || is_null($key)) {
            $options['recurse'] = true;
        }
        if ($recurse === false) {
            unset($options['recurse']);
        }

        // @TODO Fix the consul api 404 exception on a not found key to
        // instead be a ClientException.
        try {
            $result = $this->kv->get($this->getPath($key), $options);
        } catch (ServerException $e) {
            return false;
        }

        $features = json_decode($result->getBody(), true);
        if (empty($features)) {
            return [];
        }

        return $features;
    }


    /**
     * Creates or updates the features for the supplied key.
     *
     * @param string $key
     * @param array  $data
     * @param boolean $recurse
     * @return array of kv objects on success, false on failure
     */
    public function set($key, array $data)
    {
        $value = $this->encode($data);

        // @TODO should this throw an exception if a value is going to be > 512kB?

        // Note: $value will be base64 encoded as it is stored within Consul
        $result = $this->kv->put($this->getPath($key), $value);
        return json_decode($result->getBody(), true);
    }


    /**
     * Deletes the features for the supplied key.
     *
     * @param string $key
     * @param boolean $recurse
     * @return true on success, false on failure
     */
    public function delete($key = null, $recurse = null)
    {
        $options = [];
        if ($recurse || is_null($key)) {
            $options['recurse'] = true;
        }
        if ($recurse === false) {
            unset($options['recurse']);
        }

        $result = $this->kv->delete($this->getPath($key), $options);
        return json_decode($result->getBody(), true);
    }


    /**
     * Returns the KV path for the supplied key.
     *
     * @param string $key
     * @return string
     */
    public function getPath($key = null)
    {
        if (empty($key)) {
            return $this->base;
        }
        if (empty($this->base)) {
            return $key;
        }
        return $this->base . '/' . $key;
    }


    /**
     * Encodes the feature data for storage in Consul.
     *
     * @param array $data
     * @return array
     */
    public function encode($data = [])
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        $output = [
            'name' => null,
            'on' => false,
            'v' => 1,
            't' => time(),
        ];

        foreach (array_keys($output) as $idx) {
            if (array_key_exists($idx, $data)) {
                $output[$idx] = $data[$idx];
            }
        }

        return json_encode($output);
    }


    /**
     * Decodes the Consul kv response into a feature array.
     *
     * Set the includeKey to true to include the full kv path in the decoded
     * feature array. This is useful when listing all features in a
     * non-associative array.
     *
     * @param  array   $data
     * @param  boolean $includeKey
     * @return array
     */
    public function decode($data, $includeKey = false)
    {
        if (empty($data['Value'])) {
            return false;
        }

        $value = base64_decode($data['Value']);

        $decoded = json_decode($value, true);

        if ($decoded === false) {
            return false;
        }

        // Optionally include the key in the response.
        $output = $decoded;
        if ($includeKey) {
            $output = array_merge(['key' => $data['Key']], $output);
        }

        return $output;
    }
}
