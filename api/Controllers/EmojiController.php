<?php
/**
 * Emojinaija is a rest API service that provide access to
 * unlimited emoji images
 *
 * @package Ibonly\NaijaEmoji\EmojiController
 * @author  Ibraheem ADENIYI <ibonly01@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Ibonly\NaijaEmoji;

use Slim\Slim;
use Ibonly\NaijaEmoji\Emoji;
use Firebase\JWT\EmojiInterface;
use Firebase\JWT\ExpiredException;
use Ibonly\NaijaEmoji\AuthController;
use Ibonly\PotatoORM\UserNotFoundException;
use Ibonly\PotatoORM\EmptyDatabaseException;

/**
*
*/
class EmojiController implements EmojiInterface
{
    protected $dataName;
    protected $header;
    protected $auth;

    public function __construct()
    {
        $this->dataName = new Emoji();
        $this->auth = new AuthController();
    }

    public function getAllEmoji (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        try
        {
            $data = $this->dataName->getAll()->all();
            if( ! empty( $data ) )
                return $data;
        } catch ( EmptyDatabaseException $e ) {
            $app->halt(204, json_encode(['Message' => 'No content']));
        }
    }

    public function findEmoji ($id, Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        try
        {
            $data =  $this->dataName->where(['id' => $id])->all();
            if( ! empty( $data ) )
                return $data;
        } catch ( UserNotFoundException $e ) {
            $app->halt(404, json_encode(['Message' => 'Not Found']));
        }
    }

    public function insertEmoji (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ExpiredException();

            $data = $this->auth->authorizationDecode($tokenData);
            $this->dataName->id = NULL;
            $this->dataName->name = $app->request->params('name');
            $this->dataName->char = $app->request->params('char');
            $this->dataName->Keywords = $app->request->params('keywords');
            $this->dataName->category = $app->request->params('category');
            $this->dataName->date_created = date('Y-m-d G:i:s');
            $this->dataName->date_modified = date('Y-m-d G:i:s');
            $this->dataName->created_by = $data->user;

            $save = $this->dataName->save();
            if ( $save )
                $app->halt(200, json_encode(['Message' => 'Success']));
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        } catch ( SaveUserExistException $e ){
            $app->halt(202, json_encode(['Message' => 'Not Created']));
        }
    }

    public function updateEmoji ($id, Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ExpiredException();

            $find = Emoji::find($id);
            $fields = $app->request->isPut() ? $app->request->put() : $app->request->patch();
            foreach ( $fields as $key => $value )
            {
                $find->$key = $value;
            }
            $find->date_modified = date('Y-m-d G:i:s');
            $update = $find->update();
            if( $update )
                $app->halt(200, json_encode(['Message' => 'Emoji Updated Successfully']));
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        } catch ( SaveUserExistException $e ){
            $app->halt(304, json_encode(['Message' => 'Not Modified']));
        } catch ( UserNotFoundException $e ){
            $app->halt(304, json_encode(['Message' => 'Not Modified']));
        }
    }

    public function deleteEmoji ($id)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ExpiredException();

            return $this->dataName->destroy($id);
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        }
    }
}