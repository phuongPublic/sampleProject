<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MtbRegion Model
 *
 * @method \App\Model\Entity\MtbRegion get($primaryKey, $options = [])
 * @method \App\Model\Entity\MtbRegion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MtbRegion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MtbRegion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MtbRegion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MtbRegion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MtbRegion findOrCreate($search, callable $callback = null, $options = [])
 */
class MtbRegionTable extends Table
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

        $this->setTable('mtb_region');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * get the list category job
     *
     * @return array
     */
    public function getAllRegion()
    {
        try {
            $jobRegion = $this->find()
                ->hydrate(false)
                ->toArray();
            return $jobRegion;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get the list category job
     *
     * @return array
     */
    public function getRegionById($id)
    {
        try {
            $jobRegion = $this->find()
                ->where(['id' => $id])
                ->hydrate(false)
                ->first();
            return $jobRegion;
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
}
