<?php
/**
 * Defining Interface for class EmojiController.
 *
 * @package Ibonly\NaijaEmoji\EmojiController
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

interface EmojiInterface
{
    public function getAllEmoji ($app);

    public function findEmoji ($id, $app);

    public function insertEmoji ($app);

    public function updateEmoji ($id, $app);

    public function deleteEmoji ($id);
}