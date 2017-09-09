<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Crud;

use Cake\Http\Response;

/**
 * Trait CreateActionTrait
 *
 * @package Dwdm\Users\Controller\Crud
 */
trait CreateActionTrait
{
    use CrudAwareTrait;

    /**
     * Create entity
     *
     * @return Response|null
     */
    public function create()
    {
        $result = $this->dispatchEvent($this->_eventName('before'), null, $this)->getResult();

        if ($result instanceof Response) {
            return $result;
        }

        $entityClass = $this->_entityClass();

        $entity = $result instanceof $entityClass ? $result : $this->loadModel()->newEntity();

        if ($this->request->is('post')) {
            $result = $this->dispatchEvent($this->_eventName('beforeSave'), compact('entity'), $this)->getResult();

            if ($result instanceof $entityClass) {
                $entity = $result;
            } else {
                $data = isset($result['data']) && is_array($result['data']) ? $result['data'] : $this->request->getData();
                $options = isset($result['options']) && is_array($result['options']) ? $result['options'] : [];
                $entity = $this->loadModel()->patchEntity($entity, $data, $options);
            }

            if ($this->loadModel()->save($entity)) {
                $result = $this->dispatchEvent($this->_eventName('afterSave'), compact('entity'), $this)->getResult();
            } else {
                $result = $this->dispatchEvent($this->_eventName('afterFail'), compact('entity'), $this)->getResult();
            }

            if ($result instanceof Response) {
                return $result;
            }
        }

        $result = $this->dispatchEvent($this->_eventName('after'), compact('entity'), $this)->getResult();

        $entity = $result instanceof $entityClass ? $result : $entity;

        $this->set(compact('entity'));
        $this->set('_serialize', ['entity']);

        return null;
    }
}