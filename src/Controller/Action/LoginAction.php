<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Action;

use Crud\Action\BaseAction;
use Crud\Event\Subject;
use Crud\Traits\RedirectTrait;
use Crud\Traits\ViewTrait;
use Crud\Traits\ViewVarTrait;
use Dwdm\Users\Controller\PluginController;

/**
 * Class LoginAction
 * @package Dwdm\Users\Controller\Action
 */
class LoginAction extends BaseAction
{
    use RedirectTrait;
    use ViewTrait;
    use ViewVarTrait;

    /**
     * {@inheritDoc}
     */
    protected $_defaultConfig = [
        'enabled' => true,
        'scope' => 'entity',
        'view' => null,
        'viewVar' => null,
        'serialize' => [],
        'messages' => [
            'success' => [
                'text' => 'Success login'
            ],
            'error' => [
                'text' => 'Incorrect login data'
            ]
        ],
        'api' => [
            'methods' => ['post'],
            'success' => [
                'code' => 200
            ],
            'error' => [
                'code' => 400
            ]
        ]
    ];

    /**
     * HTTP GET handler
     *
     * Render login form
     */
    protected function _get()
    {
        $subject = $this->_subject();

        $this->_trigger('beforeRender', $subject);
    }

    /**
     * HTTP POST handler
     *
     * Login user
     */
    protected function _post()
    {
        $subject = $this->_subject(['entity' => null]);

        /** @var PluginController $controller */
        $controller = $this->_controller();
        $this->_trigger('beforeLogin', $subject);
        if ($user = $controller->Auth->identify()) {
            $subject->set(['user' => $user]);
            return $this->_success($subject);
        } else {
            return $this->_error($subject);
        }
    }

    /**
     * Success login callback
     *
     * @param Subject $subject
     * @return \Cake\Network\Response
     */
    protected function _success(Subject $subject)
    {
        $subject->set(['success' => true]);
        $this->_trigger('afterLogin', $subject);

        /** @var PluginController $controller */
        $controller = $this->_controller();
        $controller->Auth->setUser($subject->user);

        $this->setFlash('success', $subject);

        return $this->_redirect($subject, $controller->Auth->redirectUrl());
    }

    /**
     * Error login callback
     *
     * @param Subject $subject
     */
    protected function _error(Subject $subject)
    {
        $subject->set(['success' => false]);
        $this->_trigger('afterLogin', $subject);

        $this->setFlash('error', $subject);

        $this->_trigger('beforeRender', $subject);
    }
}