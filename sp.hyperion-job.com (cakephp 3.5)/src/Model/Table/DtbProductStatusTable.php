<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbProductStatus Model
 *
 * @property \App\Model\Table\ProductStatusesTable|\Cake\ORM\Association\BelongsTo $ProductStatuses
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\CreatorsTable|\Cake\ORM\Association\BelongsTo $Creators
 *
 * @method \App\Model\Entity\DtbProductStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbProductStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbProductStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbProductStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbProductStatus findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbProductStatusTable extends Table
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

        $this->setTable('dtb_product_status');
        $this->setDisplayField('product_status_id');
        $this->setPrimaryKey(['product_status_id', 'product_id']);

        $this->belongsTo('ProductStatuses', [
            'foreignKey' => 'product_status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->dateTime('create_date')
            ->requirePresence('create_date', 'create')
            ->notEmpty('create_date');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->requirePresence('del_flg', 'create')
            ->notEmpty('del_flg');

        return $validator;
    }

    public function getJobStatus($id)
    {
        try {
            $result = $this->find()
                ->select(['product_status_id'])
                ->where(['product_id' => $id,'del_flg' => 0])
                ->hydrate(false)
                ->toArray();
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getFileJobIdWithStatus($status)
    {
        try {
            $result = $this->find()
                ->select(['product_id'])
                ->order(['update_date' => 'DESC'])
                ->where(['product_status_id' => $status,'del_flg' => 0])
                ->limit(5)
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
        $rules->add($rules->existsIn(['product_status_id'], 'ProductStatuses'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['creator_id'], 'Creators'));

        return $rules;
    }
}
