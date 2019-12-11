<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\Core\Exception;

/**
 * TargetUser Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Opens
 *
 * @method \App\Model\Entity\TargetUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\TargetUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TargetUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TargetUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TargetUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TargetUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TargetUser findOrCreate($search, callable $callback = null)
 */
class TargetUserTable extends Table
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

        $this->table('target_user');
        $this->displayField('target_user_seq');
        $this->primaryKey(['target_user_seq', 'user_seq', 'open_id']);
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
                ->integer('target_user_seq')
                ->allowEmpty('target_user_seq', 'create');

        $validator
                ->allowEmpty('user_seq', 'create');

        $validator
                ->integer('open_type')
                ->allowEmpty('open_type');

        $validator
                ->requirePresence('mail', 'create')
                ->notEmpty('mail');

        $validator
                ->dateTime('login_date')
                ->allowEmpty('login_date');

        $validator
                ->dateTime('reg_date')
                ->notEmpty('reg_date');

        return $validator;
    }

    /**
     * check email open login
     *
     * @param string $openId, $mail
     * @throws \Exception
     * @return aray
     */
    public function checkLoginUser($openId, $mail, $userSeq)
    {
        try {
            $targetUserSelect = $this->find()
                    ->where(['open_id' => $openId,
                        'mail' => $mail])
                    ->hydrate(false)
                    ->toArray();
            return $targetUserArray = array(count($targetUserSelect), $targetUserSelect);
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get all target user info order by regdate
     *
     * @param string $openId, $userSeq
     * @throws \Exception
     * @return array
     */
    public function getAllTargetUserDate($openId, $userSeq)
    {
        try {
            //get all target user in folder
            $userList = $this->find()
                    ->order(['reg_date' => 'DESC'])
                    ->where(['user_seq' => $userSeq,
                        'open_id' => $openId])
                    ->hydrate(false)
                    ->toArray();
            return $userList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

}
