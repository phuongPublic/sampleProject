<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbProducts Model
 *
 * @property \App\Model\Table\MakersTable|\Cake\ORM\Association\BelongsTo $Makers
 * @property \App\Model\Table\CreatorsTable|\Cake\ORM\Association\BelongsTo $Creators
 * @property \App\Model\Table\DelivDatesTable|\Cake\ORM\Association\BelongsTo $DelivDates
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \App\Model\Entity\DtbProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbProduct newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProduct findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbProductsTable extends Table
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

        $this->setTable('dtb_products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('product_id');

        $this->belongsTo('Makers', [
            'foreignKey' => 'maker_id'
        ]);
        $this->belongsTo('Creators', [
            'foreignKey' => 'creator_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DelivDates', [
            'foreignKey' => 'deliv_date_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
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
            ->integer('product_id')
            ->allowEmpty('product_id', 'create');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('name_vn')
            ->allowEmpty('name_vn');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('comment1')
            ->allowEmpty('comment1');

        $validator
            ->scalar('comment2')
            ->allowEmpty('comment2');

        $validator
            ->scalar('comment3')
            ->maxLength('comment3', 16777215)
            ->allowEmpty('comment3');

        $validator
            ->scalar('comment4')
            ->allowEmpty('comment4');

        $validator
            ->scalar('comment5')
            ->allowEmpty('comment5');

        $validator
            ->scalar('comment6')
            ->allowEmpty('comment6');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->scalar('main_list_comment')
            ->allowEmpty('main_list_comment');

        $validator
            ->scalar('main_list_comment_vn')
            ->allowEmpty('main_list_comment_vn');

        $validator
            ->scalar('main_list_image')
            ->allowEmpty('main_list_image');

        $validator
            ->scalar('main_comment')
            ->maxLength('main_comment', 16777215)
            ->allowEmpty('main_comment');

        $validator
            ->scalar('main_comment_vn')
            ->maxLength('main_comment_vn', 16777215)
            ->allowEmpty('main_comment_vn');

        $validator
            ->scalar('main_image')
            ->allowEmpty('main_image');

        $validator
            ->scalar('main_large_image')
            ->allowEmpty('main_large_image');

        $validator
            ->requirePresence('del_flg', 'create')
            ->notEmpty('del_flg');

        $validator
            ->dateTime('create_date')
            ->requirePresence('create_date', 'create')
            ->notEmpty('create_date');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->allowEmpty('dummy_flg');

        $validator
            ->allowEmpty('position');

        $validator
            ->date('end_date')
            ->allowEmpty('end_date');

        $validator
            ->allowEmpty('offer_number');

        $validator
            ->scalar('client_introduction')
            ->allowEmpty('client_introduction');

        $validator
            ->scalar('client_introduction_vn')
            ->allowEmpty('client_introduction_vn');

        $validator
            ->scalar('client_zip01')
            ->allowEmpty('client_zip01');

        $validator
            ->scalar('client_zip02')
            ->allowEmpty('client_zip02');

        $validator
            ->allowEmpty('client_pref');

        $validator
            ->scalar('client_addr01')
            ->allowEmpty('client_addr01');

        $validator
            ->allowEmpty('target');

        $validator
            ->allowEmpty('employment_status');

        $validator
            ->allowEmpty('salary_type');

        $validator
            ->allowEmpty('currency');

        $validator
            ->decimal('salary_min')
            ->allowEmpty('salary_min');

        $validator
            ->decimal('salary_max')
            ->allowEmpty('salary_max');

        $validator
            ->scalar('salary')
            ->allowEmpty('salary');

        $validator
            ->scalar('salary_vn')
            ->allowEmpty('salary_vn');

        $validator
            ->scalar('exchange_rate')
            ->allowEmpty('exchange_rate');

        $validator
            ->allowEmpty('region');

        $validator
            ->allowEmpty('city');

        $validator
            ->scalar('work_location')
            ->allowEmpty('work_location');

        $validator
            ->scalar('work_location_vn')
            ->allowEmpty('work_location_vn');

        $validator
            ->scalar('traffic_access')
            ->allowEmpty('traffic_access');

        $validator
            ->scalar('traffic_access_vn')
            ->allowEmpty('traffic_access_vn');

        $validator
            ->scalar('working_hour')
            ->allowEmpty('working_hour');

        $validator
            ->scalar('working_hour_vn')
            ->allowEmpty('working_hour_vn');

        $validator
            ->scalar('working_day')
            ->allowEmpty('working_day');

        $validator
            ->scalar('working_day_vn')
            ->allowEmpty('working_day_vn');

        $validator
            ->scalar('lunch_time')
            ->allowEmpty('lunch_time');

        $validator
            ->scalar('lunch_time_vn')
            ->allowEmpty('lunch_time_vn');

        $validator
            ->scalar('trial_period')
            ->allowEmpty('trial_period');

        $validator
            ->scalar('trial_period_vn')
            ->allowEmpty('trial_period_vn');

        $validator
            ->scalar('sex')
            ->allowEmpty('sex');

        $validator
            ->scalar('qualification')
            ->allowEmpty('qualification');

        $validator
            ->scalar('qualification_vn')
            ->allowEmpty('qualification_vn');

        $validator
            ->scalar('personality')
            ->allowEmpty('personality');

        $validator
            ->scalar('personality_vn')
            ->allowEmpty('personality_vn');

        $validator
            ->scalar('skill')
            ->allowEmpty('skill');

        $validator
            ->scalar('skill_vn')
            ->allowEmpty('skill_vn');

        $validator
            ->scalar('payrise')
            ->allowEmpty('payrise');

        $validator
            ->scalar('payrise_vn')
            ->allowEmpty('payrise_vn');

        $validator
            ->scalar('bonus')
            ->allowEmpty('bonus');

        $validator
            ->scalar('bonus_vn')
            ->allowEmpty('bonus_vn');

        $validator
            ->scalar('insurance')
            ->allowEmpty('insurance');

        $validator
            ->scalar('insurance_vn')
            ->allowEmpty('insurance_vn');

        $validator
            ->scalar('welfare')
            ->allowEmpty('welfare');

        $validator
            ->scalar('other_welfare')
            ->allowEmpty('other_welfare');

        $validator
            ->scalar('other_welfare_vn')
            ->allowEmpty('other_welfare_vn');

        $validator
            ->scalar('medical_checkup')
            ->allowEmpty('medical_checkup');

        $validator
            ->scalar('medical_checkup_vn')
            ->allowEmpty('medical_checkup_vn');

        $validator
            ->scalar('applicate_method')
            ->allowEmpty('applicate_method');

        $validator
            ->scalar('applicate_method_vn')
            ->allowEmpty('applicate_method_vn');

        $validator
            ->scalar('selection_process')
            ->allowEmpty('selection_process');

        $validator
            ->integer('concierge')
            ->allowEmpty('concierge');

        return $validator;
    }


    /**
     * get the list five first job
     *
     * @return array
     */
    public function getJobInfoById($id)
    {
        try {
            $jobList = $this->find()
                ->where(['product_id' => $id, 'del_flg' => 0])
                ->hydrate(false)
                ->first();
            return $jobList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getJobNameById($id)
    {
        try {
            $jobList = $this->find()
                ->select(['name'])
                ->where(['product_id' => $id, 'del_flg' => 0])
                ->hydrate(false)
                ->first();
            return $jobList['name'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get the list basic job
     *
     * @return array
     */
    public function getJobBasicInfoById($listId)
    {
        try {
            $jobList = $this->find()
                ->select(['product_id', 'region', 'currency', 'name', 'name_vn', 'salary_min', 'salary_max', 'work_location_vn', 'main_list_comment_vn', 'main_large_image'])
                ->Where(['OR' => $listId])
                ->andWhere(['del_flg' => 0])
                ->hydrate(false)
                ->toArray();
            return $jobList;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get the list five first job
     *
     * @return array
     */
    public function getSearchResult($dataSearch)
    {
        try {

            $wheresArray = array();
            $nameJP = array();
            $nameVN = array();
            $jobDetailVN = array();
            $jobDetailJP = array();

            if (!empty($dataSearch['searchKeyword'])) {
                $nameVN['name_vn LIKE'] = '%' . $dataSearch['searchKeyword'] . '%';
                $nameJP['name LIKE'] = '%' . $dataSearch['searchKeyword'] . '%';
                $jobDetailVN['main_comment_vn LIKE'] = '%' . $dataSearch['searchKeyword'] . '%';
                $jobDetailJP['main_comment LIKE'] = '%' . $dataSearch['searchKeyword'] . '%';
            } else {
                $nameVN['name_vn LIKE'] = '%%';
                $nameJP['name LIKE'] = '%%';
                $jobDetailVN['main_comment_vn LIKE'] = '%%';
                $jobDetailJP['main_comment LIKE'] = '%%';
            }

            if (!empty($dataSearch['searchJobType'])) {
                $wheresArray['employment_status'] = $dataSearch['searchJobType'];
            }

            if (!empty($dataSearch['searchJobCart'])) {
                $wheresArray['category_id LIKE'] = '%' . $dataSearch['searchJobCart'] . '%';
            }

            if (!empty($dataSearch['searchRegion'])) {
                $wheresArray['region'] = $dataSearch['searchRegion'];
            }

            $wheresArray['del_flg'] = 0;

            $jobList = $this->find()
                ->select(['product_id', 'currency', 'region', 'name', 'name_vn', 'salary_min', 'salary_max', 'work_location_vn', 'main_list_comment_vn', 'main_large_image'])
                ->order(['product_id' => 'DESC'])
                ->where($nameVN)
                ->orWhere($nameJP)
                ->orWhere($jobDetailVN)
                ->orWhere($jobDetailJP)
                ->andWhere($wheresArray)
                ->hydrate(false)
                ->toArray();
            return $jobList;
        } catch (Exception $e) {
            throw $e;
        }
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
        $rules->add($rules->existsIn(['maker_id'], 'Makers'));
        $rules->add($rules->existsIn(['creator_id'], 'Creators'));
        $rules->add($rules->existsIn(['deliv_date_id'], 'DelivDates'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }
}
