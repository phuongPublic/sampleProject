<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbMailHistorySendIdSeq Model
 *
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistorySendIdSeq findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbMailHistorySendIdSeqTable extends Table
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

        $this->setTable('dtb_mail_history_send_id_seq');
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

    public function getNewId()
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
