<?php
/**
 * Created by IntelliJ IDEA.
 * User: nabeelshahzad
 * Date: 12/7/17
 * Time: 1:23 PM
 */

namespace VaCentral;


use Throwable;

class HttpException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
