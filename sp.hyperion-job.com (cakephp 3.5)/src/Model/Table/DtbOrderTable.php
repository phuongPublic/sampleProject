<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbOrder Model
 *
 * @property \App\Model\Table\OrderTempsTable|\Cake\ORM\Association\BelongsTo $OrderTemps
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\OrderCountriesTable|\Cake\ORM\Association\BelongsTo $OrderCountries
 * @property \App\Model\Table\DelivsTable|\Cake\ORM\Association\BelongsTo $Delivs
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\BelongsTo $Payments
 * @property \App\Model\Table\DeviceTypesTable|\Cake\ORM\Association\BelongsTo $DeviceTypes
 *
 * @method \App\Model\Entity\DtbOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbOrderTable extends Table
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

        $this->setTable('dtb_order');
        $this->setDisplayField('order_id');
        $this->setPrimaryKey('order_id');

        $this->belongsTo('OrderTemps', [
            'foreignKey' => 'order_temp_id'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrderCountries', [
            'foreignKey' => 'order_country_id'
        ]);
        $this->belongsTo('Delivs', [
            'foreignKey' => 'deliv_id'
        ]);
        $this->belongsTo('Payments', [
            'foreignKey' => 'payment_id'
        ]);
        $this->belongsTo('DeviceTypes', [
            'foreignKey' => 'device_type_id'
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
            ->integer('order_id')
            ->allowEmpty('order_id', 'create');

        $validator
            ->scalar('message')
            ->allowEmpty('message');

        $validator
            ->scalar('order_name01')
            ->allowEmpty('order_name01');

        $validator
            ->scalar('order_name02')
            ->allowEmpty('order_name02');

        $validator
            ->scalar('order_kana01')
            ->allowEmpty('order_kana01');

        $validator
            ->scalar('order_kana02')
            ->allowEmpty('order_kana02');

        $validator
            ->scalar('order_company_name')
            ->allowEmpty('order_company_name');

        $validator
            ->scalar('order_email')
            ->allowEmpty('order_email');

        $validator
            ->scalar('order_tel01')
            ->allowEmpty('order_tel01');

        $validator
            ->scalar('order_tel02')
            ->allowEmpty('order_tel02');

        $validator
            ->scalar('order_tel03')
            ->allowEmpty('order_tel03');

        $validator
            ->scalar('order_fax01')
            ->allowEmpty('order_fax01');

        $validator
            ->scalar('order_fax02')
            ->allowEmpty('order_fax02');

        $validator
            ->scalar('order_fax03')
            ->allowEmpty('order_fax03');

        $validator
            ->scalar('order_zip01')
            ->allowEmpty('order_zip01');

        $validator
            ->scalar('order_zip02')
            ->allowEmpty('order_zip02');

        $validator
            ->scalar('order_zipcode')
            ->allowEmpty('order_zipcode');

        $validator
            ->allowEmpty('order_pref');

        $validator
            ->scalar('order_addr01')
            ->allowEmpty('order_addr01');

        $validator
            ->scalar('order_addr02')
            ->allowEmpty('order_addr02');

        $validator
            ->allowEmpty('order_sex');

        $validator
            ->dateTime('order_birth')
            ->allowEmpty('order_birth');

        $validator
            ->integer('order_job')
            ->allowEmpty('order_job');

        $validator
            ->decimal('subtotal')
            ->allowEmpty('subtotal');

        $validator
            ->decimal('discount')
            ->requirePresence('discount', 'create')
            ->notEmpty('discount');

        $validator
            ->decimal('deliv_fee')
            ->allowEmpty('deliv_fee');

        $validator
            ->decimal('charge')
            ->allowEmpty('charge');

        $validator
            ->decimal('use_point')
            ->requirePresence('use_point', 'create')
            ->notEmpty('use_point');

        $validator
            ->decimal('add_point')
            ->requirePresence('add_point', 'create')
            ->notEmpty('add_point');

        $validator
            ->decimal('birth_point')
            ->requirePresence('birth_point', 'create')
            ->notEmpty('birth_point');

        $validator
            ->decimal('tax')
            ->allowEmpty('tax');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

        $validator
            ->decimal('payment_total')
            ->allowEmpty('payment_total');

        $validator
            ->scalar('payment_method')
            ->allowEmpty('payment_method');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('cv_type');

        $validator
            ->scalar('cv_file')
            ->allowEmpty('cv_file');

        $validator
            ->dateTime('create_date')
            ->requirePresence('create_date', 'create')
            ->notEmpty('create_date');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->dateTime('commit_date')
            ->allowEmpty('commit_date');

        $validator
            ->dateTime('payment_date')
            ->allowEmpty('payment_date');

        $validator
            ->requirePresence('del_flg', 'create')
            ->notEmpty('del_flg');

        $validator
            ->scalar('memo01')
            ->allowEmpty('memo01');

        $validator
            ->scalar('memo02')
            ->allowEmpty('memo02');

        $validator
            ->scalar('memo03')
            ->allowEmpty('memo03');

        $validator
            ->scalar('memo04')
            ->allowEmpty('memo04');

        $validator
            ->scalar('memo05')
            ->allowEmpty('memo05');

        $validator
            ->scalar('memo06')
            ->allowEmpty('memo06');

        $validator
            ->scalar('memo07')
            ->allowEmpty('memo07');

        $validator
            ->scalar('memo08')
            ->allowEmpty('memo08');

        $validator
            ->scalar('memo09')
            ->allowEmpty('memo09');

        $validator
            ->scalar('memo10')
            ->allowEmpty('memo10');

        return $validator;
    }

    public function getCustomerAppliedByJobId($jobId, $customerId)
    {
        $query = $this->find()
            ->join([
                'OderDetail' => [
                    'table' => 'dtb_order_detail',
                    'type' => 'INNER',
                    'conditions' => [
                        'OderDetail.order_id = DtbOrder.order_id',
                        'OderDetail.product_id' => $jobId,
                        'DtbOrder.customer_id' => $customerId,
                    ]
                ],
            ])
            ->select(['order_id'])
            ->hydrate(false)
            ->toArray();
        return $query;
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
//        $rules->add($rules->existsIn(['order_temp_id'], 'OrderTemps'));
//        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
//        $rules->add($rules->existsIn(['order_country_id'], 'OrderCountries'));
//        $rules->add($rules->existsIn(['deliv_id'], 'Delivs'));
//        $rules->add($rules->existsIn(['payment_id'], 'Payments'));
//        $rules->add($rules->existsIn(['device_type_id'], 'DeviceTypes'));

        return $rules;
    }
}
