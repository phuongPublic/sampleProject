<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Exception;

/**
 * FileTbl Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FileFolders
 * @property \Cake\ORM\Association\BelongsTo $Files
 *
 * @method \App\Model\Entity\FileTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\FileTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FileTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FileTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FileTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FileTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FileTbl findOrCreate($search, callable $callback = null)
 */
class FileTblTable extends Table
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

        $this->table('file_tbl');
        $this->displayField('name');
        $this->primaryKey(['file_id', 'user_seq']);
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
                ->allowEmpty('file_name');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->allowEmpty('extension');

        $validator
                ->integer('amount')
                ->requirePresence('amount', 'create')
                ->notEmpty('amount');

        $validator
                ->requirePresence('base', 'create')
                ->notEmpty('base');

        $validator
                ->allowEmpty('file_comment');

        $validator
                ->allowEmpty('file_uri');

        $validator
                ->allowEmpty('user_seq', 'create');

        $validator
                ->date('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->date('reg_date')
                ->requirePresence('reg_date', 'create')
                ->notEmpty('reg_date');

        return $validator;
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getSingleFileData($userSeq, $fileId)
    {
        if(is_array($fileId)) {
            $fileId = "";
        }
        try {
            $fileSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'file_id' => $fileId])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 最大FILEIDを取得
     *
     * @param string $userSeq User sequence
     * @return int $filesId The largest file id plus 1
     * @return int 1          If there is not any address in DB
     */
    public function createNewFileId($userSeq)
    {
        try {
            $query = $this->find();
            $filesId = $query->select(['largestId' => $query->func()->max('file_id')])
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
     * get folder  count
     *
     * @param string $userSeq User sequence
     * @return int $folderId
     * @return int $count
     */
    public function getFolderCountFile($userSeq, $folderId)
    {
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $count = $this->find()
                    ->where(['user_seq' => $userSeq, 'file_folder_id' => $folderId])
                    ->count();
            return $count;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * get folder amout
     *
     * @param string $userSeq User sequence
     * @return int $folderId
     * @return int $amount
     */
    public function getFolderAmount($userSeq, $folderId)
    {
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $query = $this->find();
            $amount = $query
                    ->where(['user_seq' => $userSeq, 'file_folder_id' => $folderId])
                    ->select(['sum' => $query->func()->sum('amount')])
                    ->hydrate(false)
                    ->toArray();
            return $amount;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getFolderData($userSeq, $folderId)
    {
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $fileSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'file_folder_id' => $folderId])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getFolderDataOrder($userSeq, $folderId, $sortStr)
    {
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $fileSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'file_folder_id' => $folderId])
                    ->order(['file_id' => $sortStr])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getFolderDataByFileId($userSeq, $fileId)
    {
        try {
            $fileSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'file_id IN' => $fileId])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getFileListWithKeyword($userSeq, $folderId, $keyword, $sortStr)
    {
        if(is_array($fileId)) {
            $fileId = "";
        }
        if(is_array($keyword)) {
            $keyword = "";
        }
        try {
            $query = $this->find();
            $fileSelect = $query
                    ->where(['user_seq' => $userSeq, 'file_folder_id' => $folderId])
                    ->andWhere(['OR' => [['file_name LIKE' => $keyword], ['file_comment LIKE' => $keyword]]])
                    ->order(['file_id' => $sortStr])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * 特定のファイル情報を取得する
     * @param string $userSeq $fileId
     * @return array
     */
    public function getFileListWithKeywordByAll($userSeq, $keyword, $sortStr)
    {
        if(is_array($keyword)) {
            $keyword = "";
        }
        try {
            $query = $this->find();
            $fileSelect = $query
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['OR' => [['file_name LIKE' => $keyword], ['file_comment LIKE' => $keyword]]])
                    ->order(['file_id' => $sortStr])
                    ->hydrate(false)
                    ->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('13036', $userSeq);
            throw $e;
        }
    }

    /**
     * get total file size of user
     * @param string $userSeq
     * @return array
     * @throws Exception
     */
    public function getTotalFileSize($userSeq)
    {
        try {
            $query = $this->find();
            $fileSelect = $query->select(['amount_size' => 'SUM(amount)',
                                'file_name_size' => 'SUM(LENGTH(\'file_name\'))',
                                'name_size' => 'SUM(LENGTH(\'name\'))',
                                'file_comment_size' => 'SUM(LENGTH(\'file_comment\'))',
                                'file_uri_size' => 'SUM(LENGTH(\'file_uri\'))',])
                            ->where(['user_seq' => $userSeq])
                            ->first()->toArray();
            return $fileSelect;
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
