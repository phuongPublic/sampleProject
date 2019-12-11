<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Exception;
use Cake\Core\Configure;

/**
 * UserMst Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Mobiles
 *
 * @method \App\Model\Entity\UserMst get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserMst newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserMst[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserMst|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserMst patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserMst[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserMst findOrCreate($search, callable $callback = null)
 */
class UserMstTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('user_mst');
        $this->displayField('user_seq');
        $this->primaryKey('user_seq');
        // update・insert column auto.
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    // 登録日
                    'reg_date' => 'new'
                ]
            ]
        ]);
        $this->addBehavior('LogMessage');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
                ->allowEmpty('user_seq', 'create');

        $validator
                ->requirePresence('user_address', 'create')
                ->notEmpty('user_address')
                ->add('user_address', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
                ->allowEmpty('user_name');

        $validator
                ->requirePresence('reg_flg', 'create')
                ->notEmpty('reg_flg');

        $validator
                ->requirePresence('del_flg', 'create')
                ->notEmpty('del_flg');

        $validator
                ->date('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->date('reg_date')
                ->requirePresence('reg_date', 'create')
                ->notEmpty('reg_date');

        $validator
                ->requirePresence('user_password', 'create')
                ->notEmpty('user_password');

        $validator
                ->requirePresence('base', 'create')
                ->notEmpty('base');

        $validator
                ->allowEmpty('mail_seq');

        $validator
                ->requirePresence('file_size', 'create')
                ->notEmpty('file_size');

        $validator
                ->requirePresence('album_size', 'create')
                ->notEmpty('album_size');

        $validator
                ->allowEmpty('reminder_pc');

        $validator
                ->allowEmpty('reminder_mobile');

        $validator
                ->boolean('reminder_mobile_flg')
                ->allowEmpty('reminder_mobile_flg');

        $validator
                ->boolean('reminder_pc_flg')
                ->allowEmpty('reminder_pc_flg');

        $validator
                ->integer('reminder_time')
                ->allowEmpty('reminder_time');

        $validator
                ->allowEmpty('movie_size');

        $validator
                ->dateTime('log_date')
                ->allowEmpty('log_date');

        $validator
                ->allowEmpty('google_token');

        return $validator;
    }

    /**
     * 公開用に使用
     * @param string $userSeq
     * @return array
     */
    public function getUserInformation($userSeq)
    {
        try {
            $regFlg = 1;
            $userSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'reg_flg' => $regFlg])
                    ->hydrate(false)
                    ->toArray();
            return $userSelect;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * get user information For user detail screen
     * @param string $userSeq
     * @return array
     */
    public function getUserDataForAdmin($userSeq)
    {
        try {
            $this->logMessage('82010', $userSeq); // start get user info
            $userSelect = $this->find()
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('82011', $userSeq); // end get user info
            return $userSelect;
        } catch (Exception $e) {
            $this->logMessage('82012', $userSeq);
            throw $e;
        }
    }

    /**
     * get list user information with search condition
     * @param string $searchInfo
     * @return array
     */
    public function getSearchUserData($searchInfo, $type)
    {
        //get log id
        $LogId = ($type == 'dataForView') ? ['82001', '82002', '82003'] : ['82004', '82005', '82006'];

        $this->logMessage($LogId[0]); //Start Search user
        $wheresArray = array();
        // 検索キーワード
        if (isset($searchInfo['searchKeyword']) && $searchInfo['searchKeyword'] != "") {
            // 前方一致
            if (!empty($searchInfo['matchType'])) {
                $likeKeyword = $searchInfo['searchKeyword'] . '%';
            } else {
                $likeKeyword = '%' . $searchInfo['searchKeyword'] . '%';
            }
            // 検索区分
            if (isset($searchInfo['searchType']) && $searchInfo['searchType'] == Configure::read('Common.AdminModule.AdminUser.SearchTypeBackEnd.MailAddress')) {
                $wheresArray['user_address LIKE'] = $likeKeyword;
            } else {
                $wheresArray['user_id LIKE'] = $likeKeyword;
            }
        }
        // ステータス
        if (isset($searchInfo['searchStatus']) && $searchInfo['searchStatus'] != Configure::read('Common.AdminModule.AdminUser.SearchStatusBackEnd.All')) {
            $wheresArray['del_flg'] = $searchInfo['searchStatus'];
        }
        // 更新区分
        if (isset($searchInfo['searchClass'])) {
            if ($searchInfo['searchClass'] == Configure::read('Common.AdminModule.AdminUser.SearchClassBackEnd.UpdateDate')) {
                $wheresArray['up_date >='] = $searchInfo['timeStart'];
                $wheresArray['up_date <='] = $searchInfo['timeEnd'];
            } elseif ($searchInfo['searchClass'] == Configure::read('Common.AdminModule.AdminUser.SearchClassBackEnd.LastLoginDate')) {
                $wheresArray['log_date >='] = $searchInfo['timeStart'];
                $wheresArray['log_date <='] = $searchInfo['timeEnd'];
            }
        }

        try {
            $infoSelect = $this->find()
                    ->where($wheresArray)
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage($LogId[1]); //End Search user
            return $infoSelect;
        } catch (Exception $e) {
            $this->logMessage($LogId[2]);
        }
    }
}
