<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * TopicsTbl Model
 *
 * @method \App\Model\Entity\TopicsTbl get($primaryKey, $options = [])
 * @method \App\Model\Entity\TopicsTbl newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TopicsTbl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TopicsTbl|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TopicsTbl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TopicsTbl[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TopicsTbl findOrCreate($search, callable $callback = null)
 */
class TopicsTblTable extends Table
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

        $this->table('topics_tbl');
        $this->displayField('title');
        $this->primaryKey('topicsseq');
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
                ->integer('topicsseq')
                ->allowEmpty('topicsseq', 'create');

        $validator
                ->integer('categoryid')
                ->requirePresence('categoryid', 'create')
                ->notEmpty('categoryid');

        $validator
                ->requirePresence('title', 'create')
                ->notEmpty('title');

        $validator
                ->requirePresence('contents', 'create')
                ->notEmpty('contents');

        $validator
                ->allowEmpty('file_path1');

        $validator
                ->allowEmpty('file_path2');

        $validator
                ->integer('viewflg')
                ->requirePresence('viewflg', 'create')
                ->notEmpty('viewflg');

        $validator
                ->integer('dateviewflg')
                ->allowEmpty('dateviewflg');

        $validator
                ->integer('windowflg')
                ->allowEmpty('windowflg');

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

        $validator
                ->requirePresence('updateuser', 'create')
                ->notEmpty('updateuser');

        $validator
                ->dateTime('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->requirePresence('reguser', 'create')
                ->notEmpty('reguser');

        $validator
                ->dateTime('regdate')
                ->requirePresence('regdate', 'create')
                ->notEmpty('regdate');

        return $validator;
    }

    /**
     * method getTopicsList
     * @param Int $selectYear HTML Form Submited
     * @param Int $selectCategory HTML Form Submited
     * @param Int $sort HTML URL Submited
     * @return Array $topicList
     */
    public function getTopicsList($selectYear, $categoryId, $sort)
    {
        try {
            $this->logMessage('84017');
            if ($selectYear == Configure::read('Common.AdminModule.DraftYear.Key')) {
                if ($categoryId == Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.All')) {
                    $options = ['TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.Topics'),];
                    $options2 = ['TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.ImportantTopics'),];
                    $options3 = ['TopicsTbl.viewflg' => Configure::read('Common.AdminModule.ViewFlag.Draft'),];
                } else {
                    $options = [
                        'TopicsTbl.categoryid' => $categoryId,
                        'TopicsTbl.viewflg' => Configure::read('Common.AdminModule.ViewFlag.Draft'),
                    ];
                    $options2 = '';
                    $options3 = '';
                }
            } else {
                if ($categoryId == Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.All')) {
                    $options = ['TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.Topics'),];
                    $options2 = ['TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Topics.CategoryListBackEnd.ImportantTopics'),];
                    $options3 = ['TopicsTbl.opendata LIKE' => '%' . $selectYear . '%',
                        'TopicsTbl.viewflg <>' => Configure::read('Common.AdminModule.ViewFlag.Draft'),];
                } else {
                    $options = [
                        'TopicsTbl.categoryid' => $categoryId,
                        'TopicsTbl.opendata LIKE' => '%' . $selectYear . '%',
                        'TopicsTbl.viewflg <>' => Configure::read('Common.AdminModule.ViewFlag.Draft'),
                    ];
                    $options2 = '';
                    $options3 = '';
                }
            }

            if ($sort == Configure::read('Common.AdminModule.OrderSort.DESC')) {
                $orders = ['TopicsTbl.viewflg' => 'DESC', 'TopicsTbl.opendata' => 'DESC'];
            } elseif ($sort == Configure::read('Common.AdminModule.OrderSort.ASC')) {
                $orders = ['TopicsTbl.viewflg' => 'ASC', 'TopicsTbl.opendata' => 'DESC'];
            } else {
                $orders = ['TopicsTbl.opendata' => 'DESC'];
            }

            $topicList = $this->query()
                    ->where($options)
                    ->orWhere($options2)
                    ->andWhere($options3)
                    ->order($orders)
                    ->hydrate(false);
            $this->logMessage('84018');
            return $topicList;
        } catch (Exception $ex) {
            $this->logMessage('84004');
            throw $ex;
        }
    }

    public function getCampaignList($targetYear, $sort)
    {
        try {
            $this->logMessage('85017');
            if ($targetYear == Configure::read('Common.AdminModule.DraftYear.Key')) {
                $option = [
                    'TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Category.Campaign'),
                    'TopicsTbl.viewflg' => Configure::read('Common.AdminModule.ViewFlag.Draft'),
                ];
            } else {
                $option = [
                    'TopicsTbl.categoryid' => Configure::read('Common.AdminModule.Category.Campaign'),
                    'TopicsTbl.opendata LIKE' => '%' . $targetYear . '%',
                    'TopicsTbl.viewflg <>' => Configure::read('Common.AdminModule.ViewFlag.Draft'),
                ];
            }

            if ($sort == Configure::read('Common.AdminModule.OrderSort.DESC')) {
                $order = ['TopicsTbl.viewflg' => 'DESC', 'TopicsTbl.opendata' => 'DESC'];
            } elseif ($sort == Configure::read('Common.AdminModule.OrderSort.ASC')) {
                $order = ['TopicsTbl.viewflg' => 'ASC', 'TopicsTbl.opendata' => 'DESC'];
            } else {
                $order = ['TopicsTbl.opendata' => 'DESC'];
            }
            $topicList = $this->find()
                    ->where($option)
                    ->order($order)
                    ->hydrate(false)
                    ->toArray();
            $this->logMessage('85018');
            return $topicList;
        } catch (Exception $ex) {
            $this->logMessage('85004');
            throw $ex;
        }
    }

    /**
     * method getTopics
     * @param Int $topicId HTML URL Submited
     * @return Array $topic
     */
    public function getTopics($topicId)
    {
        try {
            $this->logMessage('84011', $topicId);
            $topic = $this->find()
                    ->where(['topicsseq' => $topicId])
                    ->hydrate(false)
                    ->first();
            $this->logMessage('84012', $topicId);
            return $topic;
        } catch (Exception $ex) {
            $this->logMessage('84013', $topicId);
            throw $ex;
        }
    }

    /**
     * method getCampaign
     * @param Int $campaignId
     * @return Array
     */
    public function getCampaign($campaignId)
    {
        try {
            $this->logMessage('85011', $campaignId);
            $campaign = $this->find()
                    ->where(['topicsseq' => $campaignId])
                    ->hydrate(false)
                    ->first();
            $this->logMessage('85012', $campaignId);
            return $campaign;
        } catch (Exception $ex) {
            $this->logMessage('85013', $campaignId);
            throw $ex;
        }
    }

}
