<?php

namespace System\Libraries\Http\Messages;

use RuntimeException;

class Session
{

    /** @var string */
    protected $name = '';

    /**
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        if (self::isActive())
        {
            if (!isset($_SESSION[$this->getName()]))
            {
                $_SESSION[$this->getName()] = [];
            }
        }
        else
        {
            throw new RuntimeException('Session is not yet started.');
        }
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $key
     * @param mixed $value
     * @throws Exception\Session_InvalidKey
     */
    public function set($key, $value)
    {
        $_SESSION[$this->getName()][$key] = $value;
    }

    /**
     * 
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($_SESSION[$this->getName()][$key]);
    }

    /**
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $_SESSION[$this->getName()][$key] : $default;
    }

    /**
     * 
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        unset($_SESSION[$this->getName()][$key]);
    }

    /**
     * 
     * @param string $key
     * @return mixed
     */
    public function splice($key, $default = null)
    {
        $r = $this->get($key, $default);
        $this->delete($key);
        return $r;
    }

    /**
     * @return mixed
     */
    public static function start()
    {
        if (!self::isActive())
        {
            session_start();
        }
        return session_status();
    }

    /** @return mixed */
    public static function status()
    {
        return session_status();
    }

    /**
     * 
     * @return boolean
     */
    public static function isActive()
    {
        return self::status() === PHP_SESSION_ACTIVE;
    }

    /**
     * @return mixed
     */
    public static function destroy()
    {
        if (self::isActive())
        {
            session_destroy();
        }
        return session_status();
    }

}
