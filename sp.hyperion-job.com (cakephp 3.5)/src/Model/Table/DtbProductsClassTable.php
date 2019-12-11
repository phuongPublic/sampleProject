<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbProductsClass Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\ProductTypesTable|\Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \App\Model\Table\CreatorsTable|\Cake\ORM\Association\BelongsTo $Creators
 *
 * @method \App\Model\Entity\DtbProductsClas get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbProductsClas newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbProductsClas[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductsClas|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbProductsClas patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductsClas[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductsClas findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbProductsClassTable extends Table
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

        $this->setTable('dtb_products_class');
        $this->setDisplayField('product_class_id');
        $this->setPrimaryKey('product_class_id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Creators', [
            'foreignKey' => 'creator_id',
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
            ->integer('product_class_id')
            ->allowEmpty('product_class_id', 'create');

        $validator
            ->integer('classcategory_id1')
            ->requirePresence('classcategory_id1', 'create')
            ->notEmpty('classcategory_id1');

        $validator
            ->integer('classcategory_id2')
            ->requirePresence('classcategory_id2', 'create')
            ->notEmpty('classcategory_id2');

        $validator
            ->scalar('product_code')
            ->allowEmpty('product_code');

        $validator
            ->decimal('stock')
            ->allowEmpty('stock');

        $validator
            ->requirePresence('stock_unlimited', 'create')
            ->notEmpty('stock_unlimited');

        $validator
            ->decimal('sale_limit')
            ->allowEmpty('sale_limit');

        $validator
            ->decimal('price01')
            ->allowEmpty('price01');

        $validator
            ->decimal('price02')
            ->requirePresence('price02', 'create')
            ->notEmpty('price02');

        $validator
            ->decimal('deliv_fee')
            ->allowEmpty('deliv_fee');

        $validator
            ->decimal('point_rate')
            ->requirePresence('point_rate', 'create')
            ->notEmpty('point_rate');

        $validator
            ->dateTime('create_date')
            ->requirePresence('create_date', 'create')
            ->notEmpty('create_date');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->scalar('down_filename')
            ->allowEmpty('down_filename');

        $validator
            ->scalar('down_realfilename')
            ->allowEmpty('down_realfilename');

        $validator
            ->requirePresence('del_flg', 'create')
            ->notEmpty('del_flg');

        return $validator;
    }

    public function getProductClassIdFromProductId($product_id)
    {
        try {
            $result = $this->find()
                ->select(['product_class_id'])
                ->where(['product_id' => $product_id])
                ->hydrate(false)
                ->first();
            return $result['product_class_id'];
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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));
        $rules->add($rules->existsIn(['creator_id'], 'Creators'));

        return $rules;
    }
}
