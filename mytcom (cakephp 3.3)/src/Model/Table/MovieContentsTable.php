<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;

/**
 * MovieContents Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MovieContents
 * @property \Cake\ORM\Association\BelongsTo $MovieFolders
 * @property \Cake\ORM\Association\BelongsTo $Files
 *
 * @method \App\Model\Entity\MovieContent get($primaryKey, $options = [])
 * @method \App\Model\Entity\MovieContent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MovieContent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MovieContent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovieContent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MovieContent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MovieContent findOrCreate($search, callable $callback = null)
 */
class MovieContentsTable extends Table
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

        $this->table('movie_contents');
        $this->displayField('name');
        $this->primaryKey(['movie_contents_id', 'user_seq']);

        // update insert column auto.
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
                ->allowEmpty('movie_contents_name');

        $validator
                ->allowEmpty('name');

        $validator
                ->requirePresence('extension', 'create')
                ->notEmpty('extension');

        $validator
                ->integer('amount')
                ->requirePresence('amount', 'create')
                ->notEmpty('amount');

        $validator
                ->requirePresence('movie_contents_url', 'create')
                ->notEmpty('movie_contents_url');

        $validator
                ->allowEmpty('movie_contents_comment');

        $validator
                ->date('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->date('reg_date')
                ->requirePresence('reg_date', 'create')
                ->notEmpty('reg_date');

        $validator
                ->requirePresence('movie_capture_url', 'create')
                ->notEmpty('movie_capture_url');

        $validator
                ->requirePresence('reproduction_time', 'create')
                ->notEmpty('reproduction_time');

        $validator
                ->integer('resultcode')
                ->requirePresence('resultcode', 'create')
                ->notEmpty('resultcode');

        $validator
                ->integer('encode_status')
                ->requirePresence('encode_status', 'create')
                ->notEmpty('encode_status');

        $validator
                ->integer('encode_file_id_flv')
                ->allowEmpty('encode_file_id_flv');

        $validator
                ->integer('encode_file_id_docomo_300k')
                ->allowEmpty('encode_file_id_docomo_300k');

        $validator
                ->integer('encode_file_id_docomo_2m_qcif')
                ->allowEmpty('encode_file_id_docomo_2m_qcif');

        $validator
                ->integer('encode_file_id_docomo_2m_qvga')
                ->allowEmpty('encode_file_id_docomo_2m_qvga');

        $validator
                ->integer('encode_file_id_docomo_10m')
                ->allowEmpty('encode_file_id_docomo_10m');

        $validator
                ->integer('encode_file_id_au')
                ->allowEmpty('encode_file_id_au');

        $validator
                ->integer('encode_file_id_sb')
                ->allowEmpty('encode_file_id_sb');

        $validator
                ->integer('video_size')
                ->allowEmpty('video_size');

        $validator
                ->integer('encode_file_id_iphone')
                ->allowEmpty('encode_file_id_iphone');

        return $validator;
    }

    /**
     * get the information all movie of folder
     * @param string $userSeq $mFolderId
     * @param string $sort (default = DESC)
     * @return array
     */
    public function getContentsByMovie($userSeq, $mFolderId, $sort = 'DESC')
    {
        if(is_array($mFolderId)) {
            $mFolderId = "";
        }
        try {
            $movieSelect = $this->find()
                    ->order(['movie_contents_id' => $sort])
                    ->where(['user_seq' => $userSeq,
                        'movie_folder_id' => $mFolderId, 'encode_status !=' => 9])
                    ->hydrate(false)
                    ->toArray();
            return $movieSelect;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get the information of movie
     * @param string $userSeq $movieId
     * @return array
     */
    public function getSingleMovieData($userSeq, $movieId)
    {
        if(is_array($movieId)) {
            $movieId = "";
        }
        try {
            $movieSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'movie_contents_id' => $movieId, 'encode_status !=' => 9])
                    ->hydrate(false)
                    ->toArray();
            return $movieSelect;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get total movies size of user
     * @param string $userSeq
     * @return array
     * @throws Exception
     */
    public function getTotalMoviesSize($userSeq)
    {
        try {
            $query = $this->find();
            $fileSelect = $query->select(['amount_size' => 'SUM(amount)',
                                'movie_contents_name_size' => 'SUM(LENGTH(\'movie_contents_name\'))',
                                'movie_contents_comment_size' => 'SUM(LENGTH(\'movie_contents_comment\'))'])
                            ->where(['user_seq' => $userSeq])
                            ->first()->toArray();
            return $fileSelect;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get reproductionTime of movie
     * @param string $userSeq
     * @param string $movieContentsId
     * @throws Exception
     */
    public function getReproductionTime($userSeq, $movieContentsId)
    {
        if(is_array($movieContentsId)) {
            $movieContentsId = "";
        }
        try {
            $query = $this->find();
            $reproductionTime = $query->select(['reproduction_time'])
                    ->where(['user_seq' => $userSeq, 'movie_contents_id' => $movieContentsId])
                    ->first();
            return $reproductionTime;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get movie list
     *
     * @param string $userSeq
     * @param string $mFolderId
     * @param string $sortStr
     * @return array
     */
    public function getMovieList($userSeq, $mFolderId, $sortStr = 'ASC')
    {
        if(is_array($mFolderId)) {
            $mFolderId = "";
        }
        try {
            //get all movie content in folder
            $mContentsList = $this->find()
                    ->select(['movie_contents_id', 'movie_contents_name'])
                    ->order(['movie_contents_id' => $sortStr])
                    ->where(['user_seq' => $userSeq, 'movie_folder_id' => $mFolderId, 'encode_status !=' => 9])
                    ->toArray();

            $aContentsArray = array();
            //create array fmovie
            for ($i = 0; $i < count($mContentsList); $i++) {
                $keyData = $mContentsList[$i]['movie_contents_id'];
                $valueData = $mContentsList[$i]['movie_contents_name'];
                $aContentsArray[$keyData] = $valueData;
            }
            return $aContentsArray;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
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
            $movieFolderId = $query->select(['largestId' => $query->func()->max('movie_contents_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $movieFolderId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * method getMovieCapacity
     *
     * @param $userSeq
     * @param $movieFolderId
     * @return int
     */
    public function getMovieCapacity($userSeq, $movieFolderId)
    {
        if(is_array($movieFolderId)) {
            $movieFolderId = "";
        }
        try {
            // movie folder total capacity confirmation
            $query = $this->find();
            $movieAmount = $query->where(['user_seq' => $userSeq, 'movie_folder_id' => $movieFolderId])
                    ->select(['sum' => $query->func()->sum('amount')])
                    ->toArray();
            $amount = $movieAmount[0]['sum'];
            if (!$amount) {
                $amount = 0;
            }
            return $amount;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get movie id list by encode status
     * @param $userSeq
     * @param $encode
     * @return array
     * @throws Exception
     */
    public function getMovieByEncode($userSeq, $encode)
    {
        try {
            $movies = $this->find()
                    ->select(['movie_contents_id'])
                    ->where(['user_seq' => $userSeq, 'encode_status' => $encode])
                    ->hydrate(false)
                    ->toArray();
            return $movies;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * get the information of movie on folder
     * @param string $userSeq $movieId $folderId
     * @return array
     */
    public function getMovieDataOnFolder($userSeq, $movieId, $folderId)
    {
        if(is_array($movieId)) {
            $movieId = "";
        }
        if(is_array($folderId)) {
            $folderId = "";
        }
        try {
            $movieSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'movie_contents_id' => $movieId,
                        'movie_folder_id' => $folderId,
                        'encode_status !=' => 9])
                    ->hydrate(false)
                    ->toArray();
            return $movieSelect;
        } catch (Exception $e) {
            $this->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

}
