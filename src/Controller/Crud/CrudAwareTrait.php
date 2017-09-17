<?php
/**
 * @copyright     Copyright (c) DowebDomobile (http://dowebdomobile.ru)
 */

namespace Dwdm\Users\Controller\Crud;

use Cake\Datasource\RepositoryInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\ORM\Table;

/**
 * Trait CrudAwareTrait
 * @package Dwdm\Users\Controller\Crud
 *
 * @description Contain methods for all other CRUD traits
 *
 * @property ServerRequest $request
 *
 * @method RepositoryInterface loadModel($modelClass = null, $modelType = null)
 */
trait CrudAwareTrait
{
    /**
     * Construct event name
     *
     * @param string $name
     * @return string
     */
    protected function _eventName($name = '')
    {
        list(, $alias) = pluginSplit($this->modelClass);

        return implode('.',
            array_merge(['Controller', $alias, $this->request->getParam('action')], empty($name) ? [] : [$name]));
    }

    /**
     * Find first entity description for model
     *
     * @param string|null $modelClass
     * @return string
     * @throws \Exception
     */
    protected function _entityClass($modelClass = null)
    {
        if (null === $modelClass) {
            $modelClass = $this->modelClass;
        }

        /** @var Table $model */
        $model = $this->loadModel($modelClass, 'Table');

        $entityClass = false;
        $parentClass = $model->getEntityClass();

        while ((bool)$parentClass && (Entity::class != $parentClass)) {
            $entityClass = $parentClass;
            $parentClass = get_parent_class($entityClass);
        };

        if (!$parentClass) {
            throw new \Exception(
                __d('users', 'Model class {0} don`t have {1} child entity.', [$modelClass, Entity::class]));
        }

        return $entityClass;
    }
}