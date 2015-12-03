<?php

/**
 * Defining Interface for class AuthController.
 *
 * @package Ibonly\NaijaEmoji\AuthInterface
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

interface AuthInterface
{
    public function authorizationEncode ($username);

    public function authorizationDecode ($token);

    public function passwordEncrypt ($password);

    public function passwordDecrypt ($password, $hashPassword);

}