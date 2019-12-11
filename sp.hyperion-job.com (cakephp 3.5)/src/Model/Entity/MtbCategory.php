<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MtbCategory Entity
 *
 * @property int $id
 * @property int $object_id
 * @property string $name
 * @property string $name_vn
 * @property int $rank
 *
 * @property \App\Model\Entity\Object $object
 */
class MtbCategory extends Entity
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
        'object_id' => true,
        'name' => true,
        'name_vn' => true,
        'rank' => true,
        'object' => true
    ];
}
