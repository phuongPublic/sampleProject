<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\Core\Exception;

/**
 * OpenStatus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Opens
 * @property \Cake\ORM\Association\BelongsTo $Targets
 *
 * @method \App\Model\Entity\OpenStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpenStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpenStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpenStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpenStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpenStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpenStatus findOrCreate($search, callable $callback = null)
 */
class OpenStatusTable extends Table
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

        $this->table('open_status');
        $this->displayField('open_id');
        $this->primaryKey(['open_id', 'target_id', 'user_seq', 'open_type']);
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
                ->integer('open_type')
                ->allowEmpty('open_type', 'create');

        $validator
                ->dateTime('close_date')
                ->allowEmpty('close_date');

        $validator
                ->integer('close_type')
                ->allowEmpty('close_type');

        $validator
                ->integer('access_check')
                ->allowEmpty('access_check');

        $validator
                ->allowEmpty('nickname');

        $validator
                ->allowEmpty('message');

        $validator
                ->dateTime('reg_date')
                ->notEmpty('reg_date');

        $validator
                ->integer('download_count')
                ->allowEmpty('download_count');

        return $validator;
    }

    /**
     * 公開情報取得
     *
     * @param string $userSeq
     * @param int    $targetId
     * @param int    $openType
     * @throws \Exception
     * @return int
     */
    public function getAllOrderByOpenStatus($userSeq, $targetId, $openType)
    {
        try {
            $whereArray = ['user_seq' => $userSeq,
                'target_id' => $targetId,
                'open_type' => $openType,
                'close_date >' => date('Y-m-d 00:00:00'),
            ];
            $order = array('reg_date' => 'DESC');
            $openObjArray = $this->find()
                    ->where($whereArray)
                    ->order($order)
                    ->hydrate(false)
                    ->toArray();
            return $openObjArray;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * 公開期間のチェック
     * @param string $openId
     * @throws \Exception
     * @return array $openArray
     */
    public function checkOpenID($openId, $userSeq = null)
    {
        if(is_array($openId)) {
            $openId = "";
        }
        try {
            $openSelect = $this->find()
                    ->where(['open_id' => $openId, 'close_date >' => date('Y-m-d 00:00:00')])
                    ->hydrate(false)
                    ->toArray();
            return $openSelect;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * ダウンロード回数を取得
     * @param string $openId, $targetId, $userSeq
     * @throws \Exception
     * @return int
     */
    public function getDownloadCount($openId, $targetId, $userSeq)
    {
        try {
            $openSelect = $this->find()
                    ->select(['download_count'])
                    ->where(['open_id' => $openId,
                        'target_id' => $targetId,
                        'user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();
            $dC = \is_numeric($openSelect[0]['download_count']) ? $openSelect[0]['download_count'] : 0;
            return $dC;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get all open info order by close date prepare for Smartphone
     *
     * @param string $userSeq, $openId
     *        int $openType
     * @throws \Exception
     * @return array
     */
    public function getAllOrderByCloseDateSP($userSeq, $openType, $openId)
    {
        try {
            //get all movie content in folder
            $openList = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'open_type' => $openType,
                        'close_date >' => date('Y-m-d 00:00:00'),
                        'open_id' => $openId])
                    ->hydrate(false)
                    ->toArray();
            return $openList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get all open info order by close date
     *
     * @param string $userSeq, $openId
     *        int $openType $target_id
     * @throws \Exception
     * @return array
     */
    public function getAllOpenDataOrderByCloseDate($userSeq, $targetId, $openType)
    {
        try {
            //get all movie content in folder
            $openList = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'target_id' => $targetId,
                        'open_type' => $openType,
                        'close_date >' => date('Y-m-d 00:00:00')])
                    ->hydrate(false)
                    ->toArray();
            return $openList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get all open info order by close date
     *
     * @param string $userSeq, $openId
     *        int $openType $target_id
     * @throws \Exception
     * @return array
     */
    public function getListAllOpenDataOrderByCloseDate($userSeq, $targetId, $openType)
    {
        try {
            //get all movie content in folder
            $openList = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'target_id IN' => $targetId,
                        'open_type' => $openType,
                        'close_date >' => date('Y-m-d 00:00:00')])
                    ->hydrate(false)
                    ->toArray();
            return $openList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get all open info order by close date
     *
     * @param string $userSeq
     *        int $targetId, $openType
     * @throws \Exception
     * @return array
     */
    public function getAllOrderByCloseDate($userSeq, $targetId, $openType)
    {
        try {
            //sort string
            $sortStr = 'ASC';
            //get all movie content in folder
            $openList = $this->find()
                    ->order(['close_date' => $sortStr])
                    ->where(['user_seq' => $userSeq,
                        'target_id' => $targetId,
                        'open_type' => $openType,
                        'close_date >' => date('Y-m-d 00:00:00')])
                    ->hydrate(false)
                    ->toArray();
            return $openList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get open movie in folder
     *
     * @param string $userSeq
     *        int $openType
     *        array $targetArray
     * @throws \Exception
     * @return array
     */
    public function getOpenDistinctStatus($targetArray, $userSeq, $openType = 3)
    {
        try {
            //sort string
            $sortStr = 'DESC';
            $openList = $this->find()
                ->select(['open_id' => 'open_status.open_id',
                    'open_type' => 'open_status.open_type',
                    'target_id' => 'open_status.target_id',
                    'reg_date' => 'open_status.reg_date',
                    'close_date' => 'open_status.close_date',
                    'close_type' => 'open_status.close_type',
                    'user_seq' => 'open_status.user_seq'])
                ->distinct('open_id')
                ->from('open_status')
                ->order(['reg_date' => $sortStr])
                ->where(['user_seq' => $userSeq,
                    'target_id IN' => $targetArray,
                    'open_type' => $openType,
                    'close_date >' => date('Y-m-d 00:00:00')])
                ->hydrate(false)
                ->toArray();
            return $openList;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get open pic in folder
     *
     * @param string $userSeq
     *        int $openType
     * @throws \Exception
     * @return array
     */
    public function getOpenPicList($openId, $userSeq)
    {
        try {
            $query = $this->find()->select(['OpenStatus.target_id',
                        'name.name',
                        'OpenStatus.download_count'
                    ])->join(["table" => "pic_tbl",
                        'alias' => 'name',
                        'type' => 'inner',
                        'conditions' => 'name.pic_id = OpenStatus.target_id'
                    ])->where(['OpenStatus.open_id' => $openId,
                        'OpenStatus.target_id = name.pic_id',
                        'OpenStatus.user_seq = name.user_seq',
                        'OpenStatus.user_seq' => $userSeq])->hydrate(false)->toArray();
            for ($i = 0; $i < count($query); $i++) {
                $query[$i]['name'] = $query[$i]['name']['name'];
            }
            return $query;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get open file in folder
     *
     * @param string $userSeq
     *        int $openType
     * @throws \Exception
     * @return array
     */
    public function getOpenFileList($openId, $userSeq)
    {
        try {
            $query = $this->find()->select(['OpenStatus.target_id',
                        'name.name',
                        'OpenStatus.download_count'
                    ])->join(["table" => "file_tbl",
                        'alias' => 'name',
                        'type' => 'inner',
                        'conditions' => 'name.file_id = OpenStatus.target_id'
                    ])->where(['OpenStatus.open_id' => $openId,
                        'OpenStatus.target_id = name.file_id',
                        'OpenStatus.user_seq = name.user_seq',
                        'OpenStatus.user_seq' => $userSeq])->hydrate(false)->toArray();
            for ($i = 0; $i < count($query); $i++) {
                $query[$i]['name'] = $query[$i]['name']['name'];
            }
            return $query;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

    /**
     * Get open movie in folder
     *
     * @param string $userSeq
     *        int $openType
     * @throws \Exception
     * @return array
     */
    public function getOpenContentList($openId, $userSeq)
    {
        try {
            $query = $this->find()->select(['OpenStatus.target_id',
                        'name.name',
                        'OpenStatus.download_count'
                    ])->join(["table" => "movie_contents",
                        'alias' => 'name',
                        'type' => 'inner',
                        'conditions' => 'name.movie_contents_id = OpenStatus.target_id'
                    ])->where(['OpenStatus.open_id' => $openId,
                        'OpenStatus.target_id = name.movie_contents_id',
                        'OpenStatus.user_seq = name.user_seq',
                        'OpenStatus.user_seq' => $userSeq])->hydrate(false)->toArray();
            for ($i = 0; $i < count($query); $i++) {
                $query[$i]['name'] = $query[$i]['name']['name'];
            }
            return $query;
        } catch (Exception $e) {
            $this->logMessage('12033', $userSeq);
            throw $e;
        }
    }

}
