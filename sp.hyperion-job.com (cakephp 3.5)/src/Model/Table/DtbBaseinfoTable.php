<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DtbBaseinfo Model
 *
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\LawCountriesTable|\Cake\ORM\Association\BelongsTo $LawCountries
 *
 * @method \App\Model\Entity\DtbBaseinfo get($primaryKey, $options = [])
 * @method \App\Model\Entity\DtbBaseinfo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DtbBaseinfo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DtbBaseinfo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DtbBaseinfo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DtbBaseinfo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DtbBaseinfo findOrCreate($search, callable $callback = null, $options = [])
 */
class DtbBaseinfoTable extends Table
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

        $this->setTable('dtb_baseinfo');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('LawCountries', [
            'foreignKey' => 'law_country_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('company_name')
            ->allowEmpty('company_name');

        $validator
            ->scalar('company_kana')
            ->allowEmpty('company_kana');

        $validator
            ->scalar('zip01')
            ->allowEmpty('zip01');

        $validator
            ->scalar('zip02')
            ->allowEmpty('zip02');

        $validator
            ->scalar('zipcode')
            ->allowEmpty('zipcode');

        $validator
            ->allowEmpty('pref');

        $validator
            ->scalar('addr01')
            ->allowEmpty('addr01');

        $validator
            ->scalar('addr02')
            ->allowEmpty('addr02');

        $validator
            ->scalar('tel01')
            ->allowEmpty('tel01');

        $validator
            ->scalar('tel02')
            ->allowEmpty('tel02');

        $validator
            ->scalar('tel03')
            ->allowEmpty('tel03');

        $validator
            ->scalar('fax01')
            ->allowEmpty('fax01');

        $validator
            ->scalar('fax02')
            ->allowEmpty('fax02');

        $validator
            ->scalar('fax03')
            ->allowEmpty('fax03');

        $validator
            ->scalar('business_hour')
            ->allowEmpty('business_hour');

        $validator
            ->scalar('law_company')
            ->allowEmpty('law_company');

        $validator
            ->scalar('law_manager')
            ->allowEmpty('law_manager');

        $validator
            ->scalar('law_zip01')
            ->allowEmpty('law_zip01');

        $validator
            ->scalar('law_zip02')
            ->allowEmpty('law_zip02');

        $validator
            ->scalar('law_zipcode')
            ->allowEmpty('law_zipcode');

        $validator
            ->allowEmpty('law_pref');

        $validator
            ->scalar('law_addr01')
            ->allowEmpty('law_addr01');

        $validator
            ->scalar('law_addr02')
            ->allowEmpty('law_addr02');

        $validator
            ->scalar('law_tel01')
            ->allowEmpty('law_tel01');

        $validator
            ->scalar('law_tel02')
            ->allowEmpty('law_tel02');

        $validator
            ->scalar('law_tel03')
            ->allowEmpty('law_tel03');

        $validator
            ->scalar('law_fax01')
            ->allowEmpty('law_fax01');

        $validator
            ->scalar('law_fax02')
            ->allowEmpty('law_fax02');

        $validator
            ->scalar('law_fax03')
            ->allowEmpty('law_fax03');

        $validator
            ->scalar('law_email')
            ->allowEmpty('law_email');

        $validator
            ->scalar('law_url')
            ->allowEmpty('law_url');

        $validator
            ->scalar('law_term01')
            ->allowEmpty('law_term01');

        $validator
            ->scalar('law_term02')
            ->allowEmpty('law_term02');

        $validator
            ->scalar('law_term03')
            ->allowEmpty('law_term03');

        $validator
            ->scalar('law_term04')
            ->allowEmpty('law_term04');

        $validator
            ->scalar('law_term05')
            ->allowEmpty('law_term05');

        $validator
            ->scalar('law_term06')
            ->allowEmpty('law_term06');

        $validator
            ->scalar('law_term07')
            ->allowEmpty('law_term07');

        $validator
            ->scalar('law_term08')
            ->allowEmpty('law_term08');

        $validator
            ->scalar('law_term09')
            ->allowEmpty('law_term09');

        $validator
            ->scalar('law_term10')
            ->allowEmpty('law_term10');

        $validator
            ->scalar('email01')
            ->allowEmpty('email01');

        $validator
            ->scalar('email02')
            ->allowEmpty('email02');

        $validator
            ->scalar('email03')
            ->allowEmpty('email03');

        $validator
            ->scalar('email04')
            ->allowEmpty('email04');

        $validator
            ->decimal('free_rule')
            ->allowEmpty('free_rule');

        $validator
            ->scalar('shop_name')
            ->allowEmpty('shop_name');

        $validator
            ->scalar('shop_kana')
            ->allowEmpty('shop_kana');

        $validator
            ->scalar('shop_name_eng')
            ->allowEmpty('shop_name_eng');

        $validator
            ->decimal('point_rate')
            ->requirePresence('point_rate', 'create')
            ->notEmpty('point_rate');

        $validator
            ->decimal('welcome_point')
            ->requirePresence('welcome_point', 'create')
            ->notEmpty('welcome_point');

        $validator
            ->dateTime('update_date')
            ->requirePresence('update_date', 'create')
            ->notEmpty('update_date');

        $validator
            ->scalar('top_tpl')
            ->allowEmpty('top_tpl');

        $validator
            ->scalar('product_tpl')
            ->allowEmpty('product_tpl');

        $validator
            ->scalar('detail_tpl')
            ->allowEmpty('detail_tpl');

        $validator
            ->scalar('mypage_tpl')
            ->allowEmpty('mypage_tpl');

        $validator
            ->scalar('good_traded')
            ->allowEmpty('good_traded');

        $validator
            ->scalar('message')
            ->allowEmpty('message');

        $validator
            ->scalar('regular_holiday_ids')
            ->allowEmpty('regular_holiday_ids');

        $validator
            ->scalar('latitude')
            ->allowEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->allowEmpty('longitude');

        $validator
            ->decimal('downloadable_days')
            ->allowEmpty('downloadable_days');

        $validator
            ->allowEmpty('downloadable_days_unlimited');

        $validator
            ->decimal('exchange_rate')
            ->allowEmpty('exchange_rate');

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
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['law_country_id'], 'LawCountries'));

        return $rules;
    }
}
