<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Crud;

use Cake\Http\Response;

/**
 * Trait UpdateActionTrait
 *
 * @package Dwdm\Users\Controller\Users
 */
trait UpdateActionTrait
{
    use CrudAwareTrait;

    /**
     * Update entity
     *
     * @return Response|null
     */
    public function update()
    {
        $result = $this->dispatchEvent($this->_eventName('before'), null, $this)->getResult();

        if ($result instanceof Response) {
            return $result;
        }

        $entityClass = $this->_entityClass();

        $entity = $result instanceof $entityClass ? $result : $this->loadModel()->get($this->request->getParam('id'));

        if ($entity && $this->request->is(['post', 'put', 'patch'])) {
            $result = $this->dispatchEvent($this->_eventName('beforeSave'), compact('entity'), $this)->getResult();

            if ($result instanceof $entityClass) {
                $entity = $result;
            } else {
                $data = isset($result['data']) && is_array($result['data']) ? $result['data'] : $this->request->getData();
                $options = isset($result['options']) && is_array($result['options']) ? $result['options'] : [];
                $entity = $this->loadModel()->patchEntity($entity, $data, $options);
            }

            $eventName = $this->loadModel()->save($entity) ? 'afterSave' : 'afterFail';
            $result = $this->dispatchEvent($this->_eventName($eventName), compact('entity'), $this)->getResult();

            if ($result instanceof Response) {
                return $result;
            }
        }

        $result = $this->dispatchEvent($this->_eventName('after'), compact('entity'), $this)->getResult();

        $entity = $result instanceof $entityClass ? $result : $entity;

        $this->set(compact('entity'));
        $this->set('_serialize', ['entity']);

        return ($result instanceof Response) ? $result : null;
    }
}