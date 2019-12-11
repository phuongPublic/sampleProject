<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Weblog Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Weblogs
 *
 * @method \App\Model\Entity\Weblog get($primaryKey, $options = [])
 * @method \App\Model\Entity\Weblog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Weblog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Weblog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Weblog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Weblog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Weblog findOrCreate($search, callable $callback = null)
 */
class WeblogTable extends Table
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

        $this->table('weblog');
        $this->displayField('user_seq');
        $this->primaryKey(['user_seq', 'log_date', 'weblog_id']);
        // TODO Then replace daiary action, please check this sentence work.
        // update・insert column auto.
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    // 更新日
                    'up_date' => 'always',
                    // 登録日
                    'reg_date' => 'new'
                ]
            ]
        ]);
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
                ->date('log_date')
                ->allowEmpty('log_date', 'create');

        $validator
                ->integer('weblog_wather')
                ->allowEmpty('weblog_wather');

        $validator
                ->allowEmpty('weblog_title');

        $validator
                ->allowEmpty('weblog_body');

        $validator
                ->allowEmpty('weblog_url1');

        $validator
                ->allowEmpty('weblog_url2');

        $validator
                ->allowEmpty('weblog_url3');

        $validator
                ->dateTime('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->dateTime('reg_date')
                ->requirePresence('reg_date', 'create')
                ->notEmpty('reg_date');

        return $validator;
    }

    /**
     * get the information of weblog
     * @param string $userSeq $logDate
     * @return array
     */
    public function getWeblogData($userSeq, $logDate, $weblogid)
    {
        $weblogSelect = $this->find()
                ->where(['user_seq' => $userSeq,
                    'log_date' => $logDate,
                    'weblog_Id' => $weblogid])
                ->hydrate(false)
                ->toArray();
        return $weblogSelect;
    }
}
