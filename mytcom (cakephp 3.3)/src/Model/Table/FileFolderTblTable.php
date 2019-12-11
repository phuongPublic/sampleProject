<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Exception;

/**
 * FileFolderTbl Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FileFolders
 *
 * @method \App\Model\Entity\FileFolderTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\FileFolderTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FileFolderTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FileFolderTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileFolderTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FileFolderTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FileFolderTbl findOrCreate($search, callable $callback = null)
 */
class FileFolderTblTable extends Table
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

        $this->table('file_folder_tbl');
        $this->displayField('file_folder_id');
        $this->primaryKey(['file_folder_id', 'user_seq']);
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
                ->allowEmpty('file_folder_name');

        $validator
                ->allowEmpty('comment');

        $validator
                ->date('up_date')
                ->notEmpty('up_date');

        $validator
                ->date('reg_date')
                ->notEmpty('reg_date');

        return $validator;
    }

    /**
     * get the information of file folder
     * @param string $userSeq $folderId
     * @return array
     */
    public function getSingleFolderdata($userSeq, $folderId)
    {
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $folderSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'file_folder_id' => $folderId])
                    ->hydrate(false)
                    ->toArray();
            return $folderSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * get the information of file folder
     * @param string $userSeq $folderId
     * @return array
     */
    public function getFolderListByTarget($userSeq, $fids, $sortStr)
    {
        try {
            $folderSelect = $this->find()
                    ->where(['user_seq' => $userSeq, 'file_folder_id IN' => $fids])
                    ->order(['file_folder_id' => $sortStr])
                    ->hydrate(false)
                    ->toArray();
            return $folderSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * get the information of file folder
     * @param string $userSeq $folderId
     * @return array
     */
    public function getFolderList($userSeq)
    {
        try {
            $folderSelect = $this->find()
                    ->where(['user_seq' => $userSeq])
                    ->order(['file_folder_id' => 'ASC'])
                    ->hydrate(false)
                    ->toArray();
            return $folderSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * get the information of file folder
     * @param string $userSeq $folderId
     * @return array
     */
    public function getFolderListOrder($userSeq, $sortStr)
    {
        try {
            $folderSelect = $this->find()
                    ->where(['user_seq' => $userSeq])
                    ->order(['file_folder_id' => $sortStr])
                    ->hydrate(false)
                    ->toArray();
            return $folderSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 最大FOLDERIDを取得
     *
     * @param string $userSeq User sequence
     * @return int $filesId The largest folder id plus 1
     * @return int 1          If there is not any address in DB
     */
    public function createNewFolderId($userSeq)
    {
        try {
            $query = $this->find();
            $filesId = $query->select(['largestId' => $query->func()->max('file_folder_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $filesId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * Check record exists in table
     *
     * @param string $primaryKey $options
     * @return boolean
     *
     */
    public function checkExist($primaryKey, $options = [])
    {
        $key = (array) $this->primaryKey();
        $alias = $this->alias();
        foreach ($key as $index => $keyname) {
            $key[$index] = $alias . '.' . $keyname;
        }
        $primaryKey = (array) $primaryKey;
        if (count($key) !== count($primaryKey)) {
            return false;
        }
        $conditions = array_combine($key, $primaryKey);

        $cacheConfig = isset($options['cache']) ? $options['cache'] : false;
        $cacheKey = isset($options['key']) ? $options['key'] : false;
        $finder = isset($options['finder']) ? $options['finder'] : 'all';
        unset($options['key'], $options['cache'], $options['finder']);

        $query = $this->find($finder, $options)->where($conditions);
        if ($cacheConfig) {
            if (!$cacheKey) {
                $cacheKey = sprintf(
                        "get:%s.%s%s", $this->connection()->configName(), $this->table(), json_encode($primaryKey)
                );
            }
            $query->cache($cacheKey, $cacheConfig);
        }
        if ($query->first()) {
            return true;
        }
        return false;
    }

}
