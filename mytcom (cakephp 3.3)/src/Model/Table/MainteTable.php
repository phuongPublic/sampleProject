<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

if (!defined('DRAFT_STATUS')) {
    define('DRAFT_STATUS', 2);
}
if (!defined('MIN_DATE')) {
    define('MIN_DATE', '2000-01-01');
}

/**
 * Mainte Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Mainte
 *
 * @method \App\Model\Entity\Mainte get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mainte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mainte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mainte|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mainte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mainte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mainte findOrCreate($search, callable $callback = null)
 */
class MainteTable extends Table
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

        $this->table('mainte');
        $this->displayField('mainte_id');
        $this->primaryKey('mainte_id');

        $this->belongsTo('Mainte', [
            'foreignKey' => 'mainte_id',
            'joinType' => 'INNER'
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
                ->requirePresence('mainte_body', 'create')
                ->notEmpty('mainte_body');

        $validator
                ->allowEmpty('mainte_status');

        $validator
                ->dateTime('mainte_start_time')
                ->allowEmpty('mainte_start_time');

        $validator
                ->allowEmpty('mainte_end_flg');

        $validator
                ->dateTime('mainte_end_time')
                ->allowEmpty('mainte_end_time');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['mainte_id'], 'Mainte'));

        return $rules;
    }

    /**
     * 年によってメンテナンス一覧を得る。
     * @param type $year メンテナンス年
     * @param type $order　ソート順
     * @param type $page　ページ番号
     * @return type メンテナンス一覧
     */
    public function getMainteList($year = null, $order = null)
    {
        $orders = array();
        switch ($order) {
            case "1":
                $orders = ['mainte_status' => 'DESC', 'mainte_start_time' => 'DESC'];
                break;
            case "2":
                $orders = ['mainte_status' => 'ASC', 'mainte_start_time' => 'DESC'];
                break;
            default:
                $orders = ['mainte_start_time' => 'DESC'];
                break;
        }
        $year = ($year) ? $year : date("Y");
        if ($year == Configure::read('Common.AdminModule.DraftYear.Key')) {
            $whereConditon = ['mainte_status' => DRAFT_STATUS];
        } else {
            $whereConditon = ['mainte_status <>' => DRAFT_STATUS, 'mainte_start_time LIKE' => '%' . $year . '%'];
        }
        try {
            // メンテナンス一覧を得る
            $this->logMessage('83039');
            $mainteArray = $this->find()
                    ->where($whereConditon)
                    ->order($orders)
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('83040');
            return $mainteArray;
        } catch (Exception $ex) {
            $this->logMessage('83007');
            throw $ex;
        }
    }

    /**
     * メンテナンス情報を得る。
     * @param type $mainte_id メンテナンスId
     * @return type IDに対応するメンテナンス情報を得る。
     */
    public function getMainte($mainteId)
    {
        try {
            $this->logMessage('83017', $mainteId);
            $mainteObj = $this->find()
                    ->where(['mainte_id' => $mainteId])
                    ->hydrate(false)
                    ->first();
            $this->logMessage('83018', $mainteId);
            return $mainteObj;
        } catch (Exception $ex) {
            $this->logMessage('83019', $mainteId);
            throw $ex;
        }
    }

    public function getReservationMainte()
    {
        $mainteObj = $mainteObj = $this->find()
                ->where(['or' => ['mainte_status' => Configure::read('Common.AdminModule.Mainte.Status.Open'),
                        [
                            'mainte_status' => Configure::read('Common.AdminModule.Mainte.Status.Reservation'),
                            'mainte_start_time <=' => date("Y-m-d H:i")
                        ]
                    ]
                ])
                ->hydrate(false)
                ->toArray();
        return $mainteObj;
    }

    /**
     * 終了するためのメンテナンス情報を取得する。
     */
    public function getSubMainte()
    {
        $this->logMessage('83004');
        try {
            $mainteObj = $this->getReservationMainte();
        } catch (Exception $ex) {
            $this->logMessage('83006');
            throw $ex;
        }
        $this->logMessage('83005');
        return $mainteObj;
    }

    /**
     * クーロン開始の時、メンテナンス情報取得
     * 処理２
     */
    public function getMainteStartReservationInfo()
    {
        try {
            $this->logMessage('83028');
            $mainteObj = $this->find()
                    ->where([
                        'mainte_status' => Configure::read('Common.AdminModule.Mainte.Status.Reservation'),
                        'mainte_start_time LIKE' => '%' . date("Y-m-d H:i") . '%'
                    ])
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('83029');
            return $mainteObj;
        } catch (Exception $ex) {
            $this->logMessage('83020');
            throw $ex;
        }
    }

    /**
     * クーロン開始の時、メンテナンス開始中情報取得
     * 処理４
     */
    public function getMainteDuringStartInfo()
    {
        try {
            $this->logMessage('83030');
            $mainteObj = $this->find()
                    ->where([
                        'mainte_status' => Configure::read('Common.AdminModule.Mainte.Status.Open'),
                        'mainte_start_time <=' => date("Y-m-d H:i:00"),
                        'mainte_start_time >=' => date("Y-m-d H:i:00", strtotime("-1 minute"))
                    ])
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('83031');
            return $mainteObj;
        } catch (Exception $ex) {
            $this->logMessage('83021');
            throw $ex;
        }
    }

    /**
     * クーロン開始の時、メンテナンス終了情報取得
     * 処理6
     */
    public function getMainteFinishInfo()
    {
        try {
            $this->logMessage('83032');
            $mainteObj = $this->find()
                    ->where([
                        'mainte_status !=' => Configure::read('Common.AdminModule.Mainte.Status.Draft'),
                        'mainte_status !=' => Configure::read('Common.AdminModule.Mainte.Status.Close'),
                        'mainte_start_time <=' => date("Y-m-d H:i"),
                        'mainte_end_time LIKE' => '%' . date("Y-m-d H:i") . '%',
                        'mainte_end_flg' => 1
                    ])
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('83033');
            return $mainteObj;
        } catch (Exception $ex) {
            $this->logMessage('83022');
            throw $ex;
        }
    }

    /**
     * クーロン開始の時、メンテナンス終了対象情報を取得
     * 処理7
     */
    public function getMainteFinishDataForUpdate()
    {
        $this->logMessage('83034');
        try {
            $mainteObj = $this->getReservationMainte();
        } catch (Exception $ex) {
            $this->logMessage('83023');
            throw $ex;
        }
        $this->logMessage('83035');
        return $mainteObj;
    }

    /**
     * クーロン開始の時、メンテナンス終了対象情報を取得
     * 処理12
     */
    public function getMainteFinishData()
    {
        $this->logMessage('83034');
        try {
            $mainteObj = $this->getReservationMainte();
        } catch (Exception $ex) {
            $this->logMessage('83027');
            throw $ex;
        }
        $this->logMessage('83035');
        return $mainteObj;
    }

    /**
     * 初回取得年度から今年までのリストを生成する
     *
     * @return array 初回取得年度から今年までのリスト
     * @throws Exception データ取得処理と更新処理に失敗する場合
     */
    public function getMainteListYear()
    {
        try {
            $this->logMessage(88001);
            $query = $this->find();
            $year = $query->func()->date_format([
                'mainte_start_time' => 'identifier',
                "'%Y'" => 'literal'
            ]);
            $minYear = $query->func()->min($year);
            $results = $query->select(['year' => $minYear])
                    ->where(['mainte_start_time >= ' => MIN_DATE,
                        'mainte_status' <> DRAFT_STATUS])
                    ->hydrate(false)
                    ->toArray();
            
            if (isset($results[0]['year']) && $results[0]['year'] <= date('Y')) {
                $baseYear = $results[0]['year'];
            } else {
                $baseYear = date('Y');
            }
            $maxYear = date('Y') + 3;

            for ($i = $baseYear; $i <= $maxYear; $i++) {
                $info[$i] = $i;
            }
            $this->logMessage(88002);
            return $info;
        } catch (InternalErrorException $e) {
            debug($e);
        } catch (Exception $e) {
            $this->logMessage(88003);
            throw $e;
        }
    }

}
