<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbCustomerFavoriteProducts Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerFavoriteProduct findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbCustomerFavoriteProductsTable extends Table
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

        $this->setTable('dtb_customer_favorite_products');
        $this->setDisplayField('customer_id');
        $this->setPrimaryKey(['customer_id', 'product_id']);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->dateTime('create_date')
            ->requirePresence('create_date', 'create')
            ->notEmpty('create_date');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        return $validator;
    }

    public function getCustomerSavedJob($jobId,$customerId)
    {
        try {
            $result = $this->find()
                ->select(['customer_id'])
                ->where(['product_id' => $jobId, 'customer_id' => $customerId])
                ->hydrate(false)
                ->first();
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllJobSavedById($customerId)
    {
        try {
            $result = $this->find()
                ->select(['product_id'])
                ->where(['customer_id' => $customerId])
                ->hydrate(false)
                ->toArray();
            return $result;
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
//        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
//        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
