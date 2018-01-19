<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Crud\Controller\Component\CrudComponent;

/**
 * Class AbstractAccessComponent
 * @package Dwdm\Users\Controller\Component
 */
abstract class AbstractComponent extends Component
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        /** @var CrudComponent $Crud */
        $Crud = $this->getController()->components()->get('Crud');

        foreach ($this->getConfig('actions', []) as $action => $config) {
            if (isset($config['listeners'])) {
                unset($config['listeners']);
            }
            $Crud->mapAction($action, $config);
        }

        $publicAction = $this->getConfig('publicActions');
        if ($this->getController()->components()->has('Auth') && isset($publicAction) && is_array($publicAction)) {
            $this->getController()->Auth->allow($publicAction);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function implementedEvents()
    {
        /** @var Controller $controller */
        $controller = $this->getController();

        $listeners = $this->getConfig('actions.' . $controller->request->getParam('action') . '.listeners', []);

        return $listeners + parent::implementedEvents();
    }
}