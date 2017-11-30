<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Action;

use Crud\Action\BaseAction;
use Crud\Traits\RedirectTrait;
use Dwdm\Users\Controller\PluginController;

/**
 * Class LogoutAction
 * @package Dwdm\Users\Controller\Action
 */
class LogoutAction extends BaseAction
{
    use RedirectTrait;

    /**
     * {@inheritDoc}
     */
    protected $_defaultConfig = [
        'enabled' => true,
        'messages' => [
            'success' => [
                'text' => 'Success logout'
            ],
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

    protected function _post()
    {
        /** @var PluginController $controller */
        $controller = $this->_controller();

        $subject = $this->_subject();
        $this->setFlash('success', $subject);

        return $this->_redirect($subject, $controller->Auth->logout());
    }
}