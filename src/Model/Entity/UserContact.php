<?php
namespace Dwdm\Users\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserContact Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $value
 * @property string $replace
 * @property bool $is_login
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $token
 * @property \Cake\I18n\FrozenTime $expiration
 *
 * @property \Dwdm\Users\Model\Entity\User $user
 */
class UserContact extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
