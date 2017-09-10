<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Action;

use Cake\Controller\Component\AuthComponent;
use Cake\Http\Response;
use Dwdm\Users\Controller\Crud\CrudAwareTrait;

/**
 * Trait LoginActionTrait
 * @package Dwdm\Users\Controller\Action
 *
 * @property AuthComponent $Auth
 */
trait LoginActionTrait
{
    use CrudAwareTrait;

    /**
     * Login user.
     *
     * @return Response|null
     */
    public function login()
    {
        $result = $this->dispatchEvent($this->_eventName('before'), null, $this)->getResult();

        if ($result instanceof Response) {
            return $result;
        }

        if ($this->request->is('post')) {
            $eventName = ($user = $this->Auth->identify()) ? 'afterIdentify' : 'afterFail';
            $result = $this->dispatchEvent($this->_eventName($eventName), compact('user'), $this)->getResult();

            if ($result instanceof Response) {
                return $result;
            }
        }

        $result = $this->dispatchEvent($this->_eventName('after'), null, $this)->getResult();

        return ($result instanceof Response) ? $result : null;
    }
}