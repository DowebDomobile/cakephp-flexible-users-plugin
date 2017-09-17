<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Crud;

use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

/**
 * Trait CreateActionTrait
 *
 * @package Dwdm\Users\Controller\Crud
 *
 * @property ServerRequest $request
 *
 * @method Event dispatchEvent($name, $data = null, $subject = null)
 * @method RepositoryInterface loadModel($modelClass = null, $modelType = null)
 */
trait CreateActionTrait
{

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