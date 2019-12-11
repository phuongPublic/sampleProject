<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbCustomerCustomerIdSeq Model
 *
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbCustomerCustomerIdSeq findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbCustomerCustomerIdSeqTable extends Table
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

        $this->setTable('dtb_customer_customer_id_seq');
        $this->setDisplayField('sequence');
        $this->setPrimaryKey('sequence');
    }

    public function getMaxId()
    {
        try {
            $result = $this->find()
                ->select(['sequence'])
                ->hydrate(false)
                ->first();
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
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
            ->integer('sequence')
            ->allowEmpty('sequence', 'create');

        return $validator;
    }
}
