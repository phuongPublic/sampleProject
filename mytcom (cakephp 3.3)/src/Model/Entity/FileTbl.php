<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FileTbl Entity
 *
 * @property int $file_folder_id
 * @property int $file_id
 * @property string $file_name
 * @property string $name
 * @property string $extension
 * @property int $amount
 * @property string $base
 * @property string $file_comment
 * @property string $file_uri
 * @property string $user_seq
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 *
 * @property \App\Model\Entity\FileFolder $file_folder
 * @property \App\Model\Entity\File $file
 */
class FileTbl extends Entity
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
        'file_folder_id' => false,
        'file_id' => false,
        'user_seq' => false
    ];
}
