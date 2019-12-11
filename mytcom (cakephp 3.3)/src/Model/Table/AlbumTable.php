<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\Core\Exception;

/**
 * Album Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Albums
 *
 * @method \App\Model\Entity\Album get($primaryKey, $options = [])
 * @method \App\Model\Entity\Album newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Album[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Album|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Album patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Album[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Album findOrCreate($search, callable $callback = null)
 */
class AlbumTable extends Table
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

        $this->table('album');
        $this->displayField('album_id');
        $this->primaryKey(['album_id', 'user_seq']);
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
                ->allowEmpty('album_name');

        $validator
                ->allowEmpty('album_comment');

        $validator
                ->integer('album_pic_count')
                ->allowEmpty('album_pic_count');

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
     * get the information of album
     * @param string $userSeq $albumId
     * @return array
     */
    public function getSingleAlbumData($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            $albumSelect = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'album_id' => $albumId])
                    ->hydrate(false)
                    ->toArray();
            return $albumSelect;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * get album name
     * @param string $userSeq $albumId
     * @return array
     */
    public function getAlbumNameForPicture($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            $albumSelect = $this->find()
                    ->select(['album_id', 'album_name', 'album_comment'])
                    ->where(['user_seq' => $userSeq, 'album_id' => $albumId])
                    ->hydrate(false)
                    ->toArray();
            return $albumSelect;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * this method return current max album_id +1
     * method selectNerxtId
     *
     * @param string $userSeq
     * @return array
     */
    public function selectNextId($userSeq)
    {
        try {
            $query = $this->find();
            $albumId = $query->select(['largestId' => $query->func()->max('album_id')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $albumId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * method getAlbumName
     *
     * @param string $userSeq
     * @return array
     */
    public function getAlbumName($userSeq)
    {
        try {
            $albumList = $this->find()
                    ->select(['album_id', 'album_name'])
                    ->where(['user_seq' => $userSeq])
                    ->order(['album_id' => 'ASC'])
                    ->toArray();

            //create array with key is album_id and value is album_name
            $albumListName = array();
            foreach ($albumList as $album) {
                $albumListName[$album->album_id] = $album->album_name;
            }
            return $albumListName;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

    /**
     * Get Album name by id
     *
     * @param string $userSeq
     * @param int $albumId
     * @return string
     */
    public function getAlbumNameById($userSeq, $albumId)
    {
        if(is_array($albumId)) {
            $albumId = "";
        }
        try {
            $albumName = $this->find()
                    ->select(['album_name'])
                    ->where(['user_seq' => $userSeq,
                        'album_id' => $albumId])
                    ->hydrate(false)
                    ->first();

            return $albumName;
        } catch (Exception $e) {
            $this->logMessage('02039', $userSeq);
            throw $e;
        }
    }

}
