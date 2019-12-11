<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MtbCity Entity
 *
 * @property int $id
 * @property int $region_id
 * @property string $name
 * @property string $name_vn
 * @property int $rank
 *
 * @property \App\Model\Entity\Region $region
 */
class MtbCity extends Entity
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
        'region_id' => true,
        'name' => true,
        'name_vn' => true,
        'rank' => true,
        'region' => true
    ];
}
