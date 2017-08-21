<?php

/**
 * PHPMailer exception handler
 * @package PHPMailer
 */

namespace System\Libraries\Email;

use Exception;

class ErrorException extends Exception
{

    /**
     * Prettify error message output
     * @return string
     */
    public function __toString()
    {
        $errorMsg = '<strong>' . htmlspecialchars($this->getMessage()) . "</strong><br />\n";
        return $errorMsg;
    }

}
