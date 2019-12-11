<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbOrderDetail Entity
 *
 * @property int $order_detail_id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_class_id
 * @property string $product_name
 * @property string $product_code
 * @property string $classcategory_name1
 * @property string $classcategory_name2
 * @property float $price
 * @property float $quantity
 * @property float $point_rate
 * @property float $tax_rate
 * @property int $tax_rule
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\ProductClass $product_class
 */
class DtbOrderDetail extends Entity
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
        'order_id' => true,
        'product_id' => true,
        'product_class_id' => true,
        'product_name' => true,
        'product_code' => true,
        'classcategory_name1' => true,
        'classcategory_name2' => true,
        'price' => true,
        'quantity' => true,
        'point_rate' => true,
        'tax_rate' => true,
        'tax_rule' => true,
        'order' => true,
        'product' => true,
        'product_class' => true
    ];
}
