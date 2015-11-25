<?php

/**
 * Defining Interface for class UserInterface.
 *
 * @package Ibonly\NaijaEmoji\UserInterface
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Slim\Slim;

interface UserInterface
{

    public function createUser (Slim $app);

    public function login (Slim $app);

    public function logout (Slim $app);
}