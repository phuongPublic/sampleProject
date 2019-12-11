<?php

namespace App\Model\Table;

use Aura\Intl\Exception;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MovieFolder Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MovieFolders
 *
 * @method \App\Model\Entity\MovieFolder get($primaryKey, $options = [])
 * @method \App\Model\Entity\MovieFolder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MovieFolder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MovieFolder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovieFolder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MovieFolder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MovieFolder findOrCreate($search, callable $callback = null)
 */
class MovieFolderTable extends Table
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

        $this->table('movie_folder');
        $this->displayField('movie_folder_id');
        $this->primaryKey(['movie_folder_id', 'user_seq']);
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
                ->allowEmpty('movie_folder_name');

        $validator
                ->allowEmpty('movie_folder_comment');

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
     * get the information of movie folder
     * @param string $userSeq $mFolderId
     * @return array
     */
    public function getSingleMovieFolderData($userSeq, $mFolderId)
    {
        if(is_array($mFolderId)) {
            $mFolderId = "";
        }
        try {
            $mFolderSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'movie_folder_id' => $mFolderId])
                    ->hydrate(false)
                    ->toArray();
            return $mFolderSelect;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq);
            throw $e;
        }
    }

    /**
     * Get Movie Folder name by id
     *
     * @param string $userSeq
     * @param int $mFolderId
     * @return string
     */
    public function getFolderNameById($userSeq, $mFolderId)
    {
        if(is_array($mFolderId)) {
            $mFolderId = "";
        }
        try {
            $mFolderName = $this->find()
                    ->select(['movie_folder_name'])
                    ->where(['user_seq' => $userSeq,
                        'movie_folder_id' => $mFolderId])
                    ->hydrate(false)
                    ->first();
            return $mFolderName;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq);
            throw $e;
        }
    }

    /**
     * this method return current max movie_folder_id +1
     * method selectNextId
     *
     * @param string $userSeq
     * @return int
     * @throws Exception
     */
    public function selectNextId($userSeq)
    {
        try {
            $query = $this->find();
            $movieFolderId = $query->select(['largestId' => $query->func()->max('movie_folder_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $movieFolderId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq);
            throw $e;
        }
    }

    /**
     * method getMovieFolderName
     *
     * @param $userSeq
     * @return array
     */
    public function getMovieFolderName($userSeq)
    {
        try {
            $MovieFolderObjArray = $this->find()
                    ->select(['movie_folder_id', 'movie_folder_name'])
                    ->where(['user_seq' => $userSeq])
                    ->order(['movie_folder_id' => 'ASC'])
                    ->hydrate(false)
                    ->toArray();
            $modify = array();
            for ($i = 0; $i < count($MovieFolderObjArray); $i++) {
                $modify[$MovieFolderObjArray[$i]['movie_folder_id']] = $MovieFolderObjArray[$i]['movie_folder_name'];
            }
            return $modify;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq);
            throw $e;
        }
    }
    

}
