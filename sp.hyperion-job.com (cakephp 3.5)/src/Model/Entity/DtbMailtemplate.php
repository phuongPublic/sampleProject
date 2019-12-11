<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbMailtemplate Entity
 *
 * @property int $template_id
 * @property string $subject
 * @property string $subject_vn
 * @property string $header
 * @property string $header_vn
 * @property string $footer
 * @property string $footer_vn
 * @property int $creator_id
 * @property int $del_flg
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 *
 * @property \App\Model\Entity\Template $template
 * @property \App\Model\Entity\Creator $creator
 */
class DtbMailtemplate extends Entity
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
        'template_id' => true,
        'subject' => true,
        'subject_vn' => true,
        'header' => true,
        'header_vn' => true,
        'footer' => true,
        'footer_vn' => true,
        'creator_id' => true,
        'del_flg' => true,
        'create_date' => true,
        'update_date' => true,
        'template' => true,
        'creator' => true
    ];
}
