<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\Core\Exception;

/**
 * EncodeRequest Model
 *
 * @property \Cake\ORM\Association\BelongsTo $EncodeRequests
 */
class EncodeRequestTable extends Table
{
    //set connection encode database
    public static function defaultConnectionName() {
        return 'encode_movie';
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('encode_request');
        $this->displayField('id');
        $this->primaryKey(['id']);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    // 登録日
                    'register_date' => 'new'
                ]
            ]
        ]);
        $this->addBehavior('LogMessage');
    }
}
