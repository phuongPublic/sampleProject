<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;
use Cake\Log\Log;

/**
 * GroupTbl Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\GroupTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GroupTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupTbl findOrCreate($search, callable $callback = null)
 */
class GroupTblTable extends Table
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

        $this->table('group_tbl');
        $this->displayField('group_id');
        $this->primaryKey(['group_id', 'user_seq']);
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
                ->requirePresence('group_name', 'create')
                ->notEmpty('group_name');

        $validator
                ->dateTime('up_date')
                ->notEmpty('up_date');

        $validator
                ->dateTime('reg_date')
                ->notEmpty('reg_date');

        return $validator;
    }

    /**
     * Get the largest group Id and make new Id
     *
     * @param string $userSeq User sequence
     * @return int New group Id
     */
    public function createNewGroupId($userSeq)
    {
        try {
            $query = $this->find();
            $groupId = $query->select(['largestId' => $query->func()->max('group_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();
            return $groupId[0]['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get the number of group in DB
     *
     * @param string $userSeq user_seq
     * @return int Number of group record
     */
    public function getGroupQuantity($userSeq)
    {
        try {
            $query = $this->find();
            $groupId = $query->select(['total_record' => $query->func()->count('group_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();
            return $groupId[0]['total_record'];
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  Get group data
     *
     *  @param  string  $userSeq     user_seq
     *  @param  string  $keyword     search keyword
     *  @return array   address data (null if error occurs)
     */
    public function getGroupData($userSeq, $keyword = "")
    {
        if(is_array($keyword)) {
            $keyword = "";
        }
        try {
            if ($keyword != "") {
                $keyword = '%' . $keyword . '%';
                $whereArray = ['group_tbl.group_name LIKE' => $keyword,
                    'group_tbl.user_seq' => $userSeq];
            } else {
                $whereArray = ['group_tbl.user_seq' => $userSeq];
            }

            $query = $this->find();
            $groupDataStmt = $query
                    ->select(['group_id' => 'group_tbl.group_id',
                        'group_name' => 'group_tbl.group_name',
                        'num' => $query->func()->count('address_data.group_id')])
                    ->from('group_tbl')
                    ->join([
                        'table' => 'address_data',
                        'type' => 'LEFT',
                        'conditions' => 'address_data.group_id = group_tbl.group_id AND address_data.user_seq = group_tbl.user_seq'])
                    ->where($whereArray)
                    ->group('group_id')
                    ->group('group_name')
                    ->orderAsc('group_name')
                    ->execute();

            if ($groupDataStmt->execute()) {
                return $groupDataStmt->fetchAll('assoc');
            }
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get group name
     *
     * @param  string  $userSeq     user_seq
     * @return array   address data (null if error occurs)
     */
    public function getGroupName($userSeq)
    {
        try {
            $data = $this->find()
                    ->where(['user_seq' => $userSeq])
                    ->orderAsc('group_name')
                    ->hydrate(false)
                    ->toArray();

            $groupNameList = array();
            for ($i = 0; $i < count($data); $i++) {
                $groupNameList[$data[$i]['group_id']] = $data[$i]['group_name'];
            }
            return $groupNameList;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

}
