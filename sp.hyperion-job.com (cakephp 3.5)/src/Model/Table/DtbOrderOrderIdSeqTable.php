<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbOrderOrderIdSeq Model
 *
 * @method \App\Model\Entity\DtbOrderOrderIdSeq get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbOrderOrderIdSeq findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbOrderOrderIdSeqTable extends Table
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

        $this->setTable('dtb_order_order_id_seq');
        $this->setDisplayField('sequence');
        $this->setPrimaryKey('sequence');
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

    public function getNewOrderId()
    {
        try {
            $result = $this->find()
                ->select(['sequence'])
                ->hydrate(false)
                ->first();
            return $result['sequence']+1;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
