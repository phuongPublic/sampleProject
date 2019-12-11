<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbMailHistory Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\TemplatesTable|\Cake\ORM\Association\BelongsTo $Templates
 * @property \App\Model\Table\CreatorsTable|\Cake\ORM\Association\BelongsTo $Creators
 *
 * @method \App\Model\Entity\DtbMailHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbMailHistory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbMailHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbMailHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbMailHistory findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbMailHistoryTable extends Table
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

        $this->setTable('dtb_mail_history');
        $this->setDisplayField('send_id');
        $this->setPrimaryKey('send_id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Templates', [
            'foreignKey' => 'template_id'
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
            ->integer('send_id')
            ->allowEmpty('send_id', 'create');

        $validator
            ->dateTime('send_date')
            ->allowEmpty('send_date');

        $validator
            ->scalar('subject')
            ->allowEmpty('subject');

        $validator
            ->scalar('mail_body')
            ->allowEmpty('mail_body');

        return $validator;
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
//        $rules->add($rules->existsIn(['order_id'], 'Orders'));
//        $rules->add($rules->existsIn(['template_id'], 'Templates'));
//        $rules->add($rules->existsIn(['creator_id'], 'Creators'));

        return $rules;
    }
}
