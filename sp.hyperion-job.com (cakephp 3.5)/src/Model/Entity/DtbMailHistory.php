<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbMailHistory Entity
 *
 * @property int $send_id
 * @property int $order_id
 * @property \Cake\I18n\FrozenTime $send_date
 * @property int $template_id
 * @property int $creator_id
 * @property string $subject
 * @property string $mail_body
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Template $template
 * @property \App\Model\Entity\Creator $creator
 */
class DtbMailHistory extends Entity
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
        'send_date' => true,
        'template_id' => true,
        'creator_id' => true,
        'subject' => true,
        'mail_body' => true,
        'order' => true,
        'template' => true,
        'creator' => true
    ];
}
