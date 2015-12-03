<?php

/**
 * Defining Interface for class GetEnv.
 *
 * @package Ibonly\NaijaEmoji\GetEnvInterface
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

interface GetEnvInterface
{
    public function getKey ();

    public function getIssuedBy ();

    public function getAuthUrl ();

    public function getTestToken ();

}