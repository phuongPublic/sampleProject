<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbMailtemplate Model
 *
 * @property \App\Model\Table\TemplatesTable|\Cake\ORM\Association\BelongsTo $Templates
 * @property \App\Model\Table\CreatorsTable|\Cake\ORM\Association\BelongsTo $Creators
 *
 * @method \App\Model\Entity\DtbMailtemplate get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbMailtemplate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbMailtemplate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailtemplate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbMailtemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailtemplate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailtemplate findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbMailtemplateTable extends Table
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

        $this->setTable('dtb_mailtemplate');

        $this->setPrimaryKey('template_id');

        $this->belongsTo('Templates', [
            'foreignKey' => 'template_id',
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
            ->scalar('subject')
            ->allowEmpty('subject');

        $validator
            ->scalar('subject_vn')
            ->allowEmpty('subject_vn');

        $validator
            ->scalar('header')
            ->allowEmpty('header');

        $validator
            ->scalar('header_vn')
            ->allowEmpty('header_vn');

        $validator
            ->scalar('footer')
            ->allowEmpty('footer');

        $validator
            ->scalar('footer_vn')
            ->allowEmpty('footer_vn');

        $validator
            ->requirePresence('del_flg', 'create')
            ->notEmpty('del_flg');

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

    public function getTemplateMailById($id)
    {
        try {
            $result = $this->find()
                ->where(['template_id' => $id])
                ->hydrate(false)
                ->first();
            return $result;
        } catch (Exception $e) {
            return false;
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
        $rules->add($rules->existsIn(['template_id'], 'Templates'));
        $rules->add($rules->existsIn(['creator_id'], 'Creators'));

        return $rules;
    }
}
