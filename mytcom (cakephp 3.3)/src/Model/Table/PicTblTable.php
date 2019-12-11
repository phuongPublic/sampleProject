<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Exception;

/**
 * PicTbl Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Pics
 * @property \Cake\ORM\Association\BelongsTo $Albums
 *
 * @method \App\Model\Entity\PicTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\PicTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PicTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PicTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PicTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PicTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PicTbl findOrCreate($search, callable $callback = null)
 */
class PicTblTable extends Table
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

        $this->table('pic_tbl');
        $this->displayField('name');
        $this->primaryKey(['pic_id', 'user_seq']);
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
                ->allowEmpty('pic_name');

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
                ->requirePresence('base', 'create')
                ->notEmpty('base');

        $validator
                ->requirePresence('pic_url', 'create')
                ->notEmpty('pic_url');

        $validator
                ->allowEmpty('pic_comment');

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
     * get the information of picture
     * @param string $userSeq $picId
     * @return array
     */
    public function getSinglePicData($userSeq, $picId)
    {
        if(is_array($picId)) {
            $picId = "";
        }
        try {
            $picSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'pic_id' => $picId])
                    ->hydrate(false)
                    ->toArray();
            return $picSelect;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get the information all picture of album
     * @param string $userSeq $albumId
     * @param string $type (default = Array)
     * @return array
     */
    public function getPicByAlbum($userSeq, $albumId, $sort = 'DESC')
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            $picSelect = $this->find()
                    ->order(['pic_id' => $sort])
                    ->where(['user_seq' => $userSeq,
                        'album_id' => $albumId])
                    ->hydrate(false)
                    ->toArray();
            return $picSelect;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get the next picture ID
     * @param string $userSeq
     * @return string
     */
    public function selectNextId($userSeq)
    {
        try {
            $query = $this->find();
            $picId = $query->select(['largestId' => $query->func()->max('pic_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $picId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get max picture ID for album
     * @param string $userSeq
     * @return string
     */
    public function getThumbForAlbum($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            $query = $this->find();
            $picId = $query->select(['largestId' => $query->func()->max('pic_id')])
                    ->where(['user_seq' => $userSeq, 'album_id' => $albumId])
                    ->hydrate(false)
                    ->first();
            return $picId['largestId'];
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get the information foreach picture in an album
     *
     * @param string $userSeq
     * @param string $albumId
     * @return array
     */
    public function getPictureInfo($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            //picture list of an album
            $pictureList = $this->find()
                    ->order(['pic_id' => 'DESC'])
                    ->where(['user_seq' => $userSeq])
                    ->where(['album_id' => $albumId])
                    ->toArray();
            return $pictureList;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get the list five first picture for preview on pc
     *
     * @param string $userSeq
     * @param string $albumId
     * @return array
     */
    public function getFivePictureInfo($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            // 他Model情報取得
            //get information 5 picture of an album
            $pictureList = $this->find()
                    ->order(['pic_id' => 'DESC'])
                    ->where(['user_seq' => $userSeq])
                    ->where(['album_id' => $albumId])
                    ->limit(5)
                    ->toArray();

            return $pictureList;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get Picture List
     *
     * @param string $userSeq
     * @param string $albumId
     * @return int
     */
    public function getPictureList($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            //sort string
            $sortStr = 'ASC';
            //get all movie content in folder
            $albumContentsList = $this->find()
                    ->select(['pic_id', 'name'])
                    ->order(['pic_id' => $sortStr])
                    ->where(['user_seq' => $userSeq, 'album_id' => $albumId])
                    ->toArray();

            $aContentsArray = array();
            //create array Album
            for ($i = 0; $i < count($albumContentsList); $i++) {
                $keyData = $albumContentsList[$i]['pic_id'];
                $valueData = $albumContentsList[$i]['name'];
                $aContentsArray[$keyData] = $valueData;
            }
            return $aContentsArray;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get total pic size of user
     * @param string $userSeq
     * @return array
     * @throws Exception
     */
    public function getTotalPicSize($userSeq)
    {
        try {
            $query = $this->find();
            $picSelect = $query->select(['amount_size' => 'SUM(amount)',
                                'file_name_size' => 'SUM(LENGTH(\'pic_name\'))',
                                'name_size' => 'SUM(LENGTH(\'name\'))',
                                'pic_url_size' => 'SUM(LENGTH(\'pic_url\'))',
                                'pic_comment_size' => 'SUM(LENGTH(\'pic_comment\'))',])
                            ->where(['user_seq' => $userSeq])
                            ->first()->toArray();
            return $picSelect;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get single picture download data
     *
     * @param string $userSeq
     * @param string $picId
     * @param string $agent
     * @return array $picSelect
     */
    public function getSinglePictureData($userSeq, $picId, $agent = 'default')
    {
        $picSelect = $this->getSinglePicData($userSeq, $picId);
        if (count($picSelect) == 0) {
            return array();
        }
        if (preg_match("/Macintosh/isx", $agent)) {
            $name = $picSelect [1][0]['name'];
        } else {
            $name = mb_convert_encoding($picSelect[0]['name'], "SJIS-WIN", "UTF-8");
        }
        $name = preg_replace("/\s/", "", $name);
        $picSelect[0]['origin_name'] = $picSelect[0]['name'];
        $picSelect[0]['name'] = $name;
        return $picSelect[0];
    }

}
