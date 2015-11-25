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
use Firebase\JWT\ExpiredException;
use Ibonly\NaijaEmoji\EmojiInterface;
use Ibonly\NaijaEmoji\AuthController;
use Ibonly\PotatoORM\UserNotFoundException;
use Ibonly\PotatoORM\EmptyDatabaseException;
use Ibonly\NaijaEmoji\ProvideTokenException;
use Ibonly\NaijaEmoji\InvalidTokenException;

class EmojiController implements EmojiInterface
{
    protected $dataName;
    protected $auth;

    public function __construct()
    {
        $this->dataName = new Emoji();
        $this->auth = new AuthController();
    }

    /**
     * getAllEmoji Get all the emoji's available
     *
     * @param  $app
     *
     * @return json
     */
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

    /**
     * findEmoji Find a particular emoji
     *
     * @param  $id
     * @param  $app
     *
     * @return json
     */
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

    /**
     * insertEmoji Insert new emoji
     *
     * @param  $app
     *
     * @return json
     */
    public function insertEmoji (Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ProvideTokenException();

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
                return $save;
                // $app->halt(200, json_encode(['Message' => 'Success']));
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        } catch ( SaveUserExistException $e ){
            $app->halt(202, json_encode(['Message' => 'Not Created']));
        } catch ( InvalidTokenException $e ){
            $app->halt(405, json_encode(['Message' => 'Invalid Token']));
        } catch ( ProvideTokenException $e ){
            $app->halt(406, json_encode(['Message' => 'Enter a valid Token']));
        }
    }

    /**
     * updateEmoji update emoji details
     *
     * @param  $id
     * @param  $app
     *
     * @return json
     */
    public function updateEmoji ($id, Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ProvideTokenException();

            $find = Emoji::find($id);
            $this->auth->authorizationDecode($tokenData);
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
            $app->halt(304, json_encode(['Message' => 'Invalid Credential supplied']));
        } catch ( InvalidTokenException $e ){
            $app->halt(405, json_encode(['Message' => 'Invalid Token']));
        } catch ( ProvideTokenException $e ){
            $app->halt(406, json_encode(['Message' => 'Enter a valid Token']));
        }
    }

    /**
     * deleteEmoji Delete already existing emoji
     *
     * @param  $id
     * @param  $app
     *
     * @return json
     */
    public function deleteEmoji ($id, Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tokenData = $app->request->headers->get('Authorization');
        try
        {
            if ( ! isset( $tokenData ) )
                throw new ProvideTokenException();

            $this->auth->authorizationDecode($tokenData);
            return $this->dataName->destroy($id);
        } catch ( ExpiredException $e ){
            $app->halt(401, json_encode(['Message' => 'Not Authorized']));
        } catch ( InvalidTokenException $e ){
            $app->halt(405, json_encode(['Message' => 'Invalid Token']));
        } catch ( ProvideTokenException $e ){
            $app->halt(406, json_encode(['Message' => 'Enter a valid Token']));
        }
    }
}