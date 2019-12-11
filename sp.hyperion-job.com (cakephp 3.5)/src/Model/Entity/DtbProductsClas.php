<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbProductsClas Entity
 *
 * @property int $product_class_id
 * @property int $product_id
 * @property int $classcategory_id1
 * @property int $classcategory_id2
 * @property int $product_type_id
 * @property string $product_code
 * @property float $stock
 * @property int $stock_unlimited
 * @property float $sale_limit
 * @property float $price01
 * @property float $price02
 * @property float $deliv_fee
 * @property float $point_rate
 * @property int $creator_id
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 * @property string $down_filename
 * @property string $down_realfilename
 * @property int $del_flg
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\ProductType $product_type
 * @property \App\Model\Entity\Creator $creator
 */
class DtbProductsClas extends Entity
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
        'product_id' => true,
        'classcategory_id1' => true,
        'classcategory_id2' => true,
        'product_type_id' => true,
        'product_code' => true,
        'stock' => true,
        'stock_unlimited' => true,
        'sale_limit' => true,
        'price01' => true,
        'price02' => true,
        'deliv_fee' => true,
        'point_rate' => true,
        'creator_id' => true,
        'create_date' => true,
        'update_date' => true,
        'down_filename' => true,
        'down_realfilename' => true,
        'del_flg' => true,
        'product' => true,
        'product_type' => true,
        'creator' => true
    ];
}
