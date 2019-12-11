<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MovieContent Entity
 *
 * @property int $movie_contents_id
 * @property int $movie_folder_id
 * @property string $user_seq
 * @property string $movie_contents_name
 * @property string $name
 * @property string $extension
 * @property int $amount
 * @property string $movie_contents_url
 * @property string $movie_contents_comment
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 * @property string $movie_capture_url
 * @property string $reproduction_time
 * @property int $resultcode
 * @property int $file_id
 * @property int $encode_status
 * @property int $encode_file_id_flv
 * @property int $encode_file_id_docomo_300k
 * @property int $encode_file_id_docomo_2m_qcif
 * @property int $encode_file_id_docomo_2m_qvga
 * @property int $encode_file_id_docomo_10m
 * @property int $encode_file_id_au
 * @property int $encode_file_id_sb
 * @property int $video_size
 * @property int $encode_file_id_iphone
 *
 * @property \App\Model\Entity\MovieContent $movie_content
 * @property \App\Model\Entity\MovieFolder $movie_folder
 * @property \App\Model\Entity\File $file
 */
class MovieContent extends Entity
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
        'movie_contents_id' => false,
        'user_seq' => false
    ];
}
