<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbOrderDetail Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\ProductClassesTable|\Cake\ORM\Association\BelongsTo $ProductClasses
 *
 * @method \App\Model\Entity\DtbOrderDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbOrderDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbOrderDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbOrderDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbOrderDetailTable extends Table
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

        $this->setTable('dtb_order_detail');
        $this->setDisplayField('order_detail_id');
        $this->setPrimaryKey('order_detail_id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductClasses', [
            'foreignKey' => 'product_class_id',
            'joinType' => 'INNER'
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
            ->integer('order_detail_id')
            ->allowEmpty('order_detail_id', 'create');

        $validator
            ->scalar('product_name')
            ->requirePresence('product_name', 'create')
            ->notEmpty('product_name');

        $validator
            ->scalar('product_code')
            ->allowEmpty('product_code');

        $validator
            ->scalar('classcategory_name1')
            ->allowEmpty('classcategory_name1');

        $validator
            ->scalar('classcategory_name2')
            ->allowEmpty('classcategory_name2');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->decimal('quantity')
            ->allowEmpty('quantity');

        $validator
            ->decimal('point_rate')
            ->requirePresence('point_rate', 'create')
            ->notEmpty('point_rate');

        $validator
            ->decimal('tax_rate')
            ->allowEmpty('tax_rate');

        $validator
            ->allowEmpty('tax_rule');

        return $validator;
    }

    public function getAppliedByCustomerId($customerId)
    {
        $query = $this->find()
            ->join([
                'Oder' => [
                    'table' => 'dtb_order',
                    'type' => 'INNER',
                    'conditions' => [
                        'Oder.order_id = DtbOrderDetail.order_id',
                        'Oder.customer_id' => $customerId,
                    ]
                ],
            ])
            ->select(['product_id'])
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
//        $rules->add($rules->existsIn(['order_id'], 'Orders'));
//        $rules->add($rules->existsIn(['product_id'], 'Products'));
//        $rules->add($rules->existsIn(['product_class_id'], 'ProductClasses'));

        return $rules;
    }
}
