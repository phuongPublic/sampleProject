<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AddressData Entity
 *
 * @property int $adrdata_seq
 * @property string $user_seq
 * @property string $name_l
 * @property string $name_f
 * @property string $nickname
 * @property string $email
 * @property string $org_name
 * @property string $org_post
 * @property string $work_countory
 * @property string $work_postcode
 * @property string $work_pref
 * @property string $work_adr1
 * @property string $work_adr2
 * @property string $work_tel
 * @property string $work_fax
 * @property string $work_url
 * @property string $home_countory
 * @property string $home_postcode
 * @property string $home_pref
 * @property string $home_adr1
 * @property string $home_adr2
 * @property string $home_cell
 * @property string $home_tel
 * @property string $home_fax
 * @property string $home_url
 * @property string $birthday
 * @property string $note
 * @property \Cake\I18n\Time $ins_date
 * @property \Cake\I18n\Time $upd_date
 * @property int $group_id
 *
 * @property \App\Model\Entity\Group $group
 */
class AddressData extends Entity
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
        '*' => true,
        'adrdata_seq' => false
    ];
}
