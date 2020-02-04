<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Trait ControllerTrait
 *
 * @package App\Controller
 */
trait ControllerTrait
{

    protected $sessionId;

    function __construct()
    {
        $session = new Session();
        if (!$session->get('session_id')) {
            $this->sessionId = $session->set('session_id', md5(time()));
        } else {
            $this->sessionId = $session->get('session_id');
        }

    }

    /**
     * @param $json
     *
     * @return mixed
     */
    function asArray($json)
    {
        return json_decode($json, true);
    }

    /**
     * @param $json
     *
     * @return mixed
     */
    function asObject($json)
    {
        return json_decode($json);
    }

}
