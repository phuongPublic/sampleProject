<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbCustomerFavoriteProduct Entity
 *
 * @property int $customer_id
 * @property int $product_id
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Product $product
 */
class DtbCustomerFavoriteProduct extends Entity
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
        'create_date' => true,
        'update_date' => true,
        'customer' => true,
        'product' => true
    ];
}
