<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MtbCategory Model
 *
 * @property \App\Model\Table\ObjectsTable|\Cake\ORM\Association\BelongsTo $Objects
 *
 * @method \App\Model\Entity\MtbCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\MtbCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MtbCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MtbCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MtbCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MtbCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MtbCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class MtbCategoryTable extends Table
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

        $this->setTable('mtb_category');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Objects', [
            'foreignKey' => 'object_id'
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
    public function getAllCartegoryJob()
    {
        try {
            $jobcart = $this->find()
                ->hydrate(false)
                ->toArray();
            return $jobcart;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get the list category job
     *
     * @return array
     */
    public function getAllCartegoryJobForMobile()
    {
        try {
            $jobcart = $this->find()
                ->hydrate(false)
                ->toArray();
            return $jobcart;
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
        $rules->add($rules->existsIn(['object_id'], 'Objects'));

        return $rules;
    }
}
