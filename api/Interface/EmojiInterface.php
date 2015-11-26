<?php

/**
 * Defining Interface for class EmojiController.
 *
 * @package Ibonly\NaijaEmoji\EmojiController
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Slim\Slim;

interface EmojiInterface
{
    public function getAllEmoji (Slim $app);

    public function findEmoji ($id, Slim $app);

    public function insertEmoji (Slim $app);

    public function updateEmoji ($id, Slim $app);

    public function deleteEmoji ($id, Slim $app);
}