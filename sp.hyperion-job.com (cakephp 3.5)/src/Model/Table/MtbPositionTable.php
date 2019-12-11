<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MtbPosition Model
 *
 * @method \App\Model\Entity\MtbPosition get($primaryKey, $options = [])
 * @method \App\Model\Entity\MtbPosition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MtbPosition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MtbPosition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MtbPosition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MtbPosition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MtbPosition findOrCreate($search, callable $callback = null, $options = [])
 */
class MtbPositionTable extends Table
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

        $this->setTable('mtb_position');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->allowEmpty('name');

        $validator
            ->scalar('name_vn')
            ->allowEmpty('name_vn');

        $validator
            ->requirePresence('rank', 'create')
            ->notEmpty('rank');

        return $validator;
    }

    /**
     * get the list category job
     *
     * @return array
     */
    public function getPositionById($id)
    {
        try {
            $jobPosition = $this->find()
                ->where(['id' => $id])
                ->hydrate(false)
                ->first();
            return $jobPosition;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
