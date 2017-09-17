<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Component;

use Cake\Controller\Component;

/**
 * Class AbstractAccessComponent
 * @package Dwdm\Users\Controller\Component
 */
abstract class AbstractAccessComponent extends Component
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $publicAction = $this->getConfig('publicActions');
        if ($this->getController()->components()->has('Auth') && isset($publicAction) && is_array($publicAction)) {
            $this->getController()->Auth->allow($publicAction);
        }
    }

}