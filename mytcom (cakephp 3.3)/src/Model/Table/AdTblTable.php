<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Exception;

/**
 * AdTbl Model
 *
 * @method \App\Model\Entity\AdTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdTbl findOrCreate($search, callable $callback = null)
 */
class AdTblTable extends Table
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

        $this->table('ad_tbl');
        $this->displayField('title');
        $this->primaryKey('adseq');
        // update・insert column auto.
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'up_date' => 'always',
                    // 登録日
                    'regdate' => 'new'
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
            ->integer('adseq')
            ->allowEmpty('adseq', 'create');

        $validator
            ->requirePresence('contents', 'create')
            ->notEmpty('contents');

        $validator
            ->integer('pub_flg')
            ->allowEmpty('pub_flg');

        $validator
            ->integer('pos_flg')
            ->allowEmpty('pos_flg');

        $validator
            ->allowEmpty('file_path');

        $validator
            ->integer('viewflg')
            ->requirePresence('viewflg', 'create')
            ->notEmpty('viewflg');

        $validator
            ->integer('timerflg')
            ->allowEmpty('timerflg');

        $validator
            ->dateTime('opendata')
            ->requirePresence('opendata', 'create')
            ->notEmpty('opendata');

        $validator
            ->dateTime('timerdata')
            ->allowEmpty('timerdata');

        return $validator;
    }

    /**
     * 広告情報を広告ＩＤで取得する
     * @param int $adSeq
     * @param string $action
     * @return array 一つの広告情報
     * @throws Exception
     */
    public function getAd($adSeq, $action = 'update')
    {
        // 広告編集の場合かプレビューの場合か、ログＩＤを設定する
        $logIdArr = ($action = 'update') ? ['86011', '86012', '86013'] : ['86019', '86020', '86021'];
        try {
            $this->logMessage($logIdArr[0], $adSeq);
            $adObj = $this->find()
                    ->where(['adseq' => $adSeq])
                    ->hydrate(false)
                    ->first();
            $this->logMessage($logIdArr[1], $adSeq);
            return $adObj;
        } catch (Exception $ex) {
            $this->logMessage($logIdArr[2], $adSeq);
            throw $ex;
        }
    }

    /**
     * 広告情報の一覧を取得する
     * @param int $year
     * @param int $sort
     * @return array 広告情報の一覧
     * @throws Exception
     */
    public function getAdList($year, $sort)
    {
        try {
            $this->logMessage('86017');
            if ($year == Configure::read('Common.AdminModule.DraftYear.Key')) {
                $where = ['AdTbl.viewflg' => Configure::read('Common.AdminModule.ViewFlag.Draft')];
            } else {
                $where = [
                    'AdTbl.opendata LIKE' => '%' . $year . '%',
                    'AdTbl.viewflg <>' => Configure::read('Common.AdminModule.ViewFlag.Draft'),
                ];
            }

            if ($sort == Configure::read('Common.AdminModule.OrderSort.DESC')) {
                $order = ['AdTbl.viewflg' => 'DESC', 'AdTbl.opendata' => 'DESC'];
            } elseif ($sort == Configure::read('Common.AdminModule.OrderSort.ASC')) {
                $order = ['AdTbl.viewflg' => 'ASC', 'AdTbl.opendata' => 'DESC'];
            } else {
                $order = ['AdTbl.opendata' => 'DESC'];
            }

            $list = $this->find()
                ->where($where)
                ->order($order)
                ->hydrate(false)
                ->toArray();
            $this->logMessage('86018');
            return $list;
        } catch (Exception $e) {
            $this->logMessage('86004');
            throw $e;
        }
    }
}
