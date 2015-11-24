<?php
/**
 * Defining Interface for class UserInterface.
 *
 * @package Ibonly\NaijaEmoji\UserInterface
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

interface UserInterface
{

    public function createUser ($app);

    public function login ($app);

    public function logout ($app);
}