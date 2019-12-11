<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbCustomerCareer Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property float $working_year
 * @property string $working_company_name
 * @property string $company_addr
 * @property string $job_description
 * @property string $position
 * @property string $working_member_num
 * @property string $working_status
 * @property string $working_position
 * @property string $working_type
 * @property string $working_experience
 *
 * @property \App\Model\Entity\Customer $customer
 */
class DtbCustomerCareer extends Entity
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
        'customer_id' => true,
        'start_date' => true,
        'end_date' => true,
        'working_year' => true,
        'working_company_name' => true,
        'company_addr' => true,
        'job_description' => true,
        'working_member_num' => true,
        'working_status' => true,
        'working_position' => true,
        'working_type' => true,
        'working_experience' => true,
        'customer' => true
    ];
}
