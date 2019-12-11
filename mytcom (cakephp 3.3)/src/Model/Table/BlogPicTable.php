<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BlogPic Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BlogPics
 * @property \Cake\ORM\Association\BelongsTo $Pics
 * @property \Cake\ORM\Association\BelongsTo $Albums
 * @property \Cake\ORM\Association\BelongsTo $Weblogs
 *
 * @method \App\Model\Entity\BlogPic get($primaryKey, $options = [])
 * @method \App\Model\Entity\BlogPic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BlogPic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BlogPic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BlogPic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BlogPic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BlogPic findOrCreate($search, callable $callback = null)
 */
class BlogPicTable extends Table
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

        $this->table('blog_pic');
        $this->displayField('blog_pic_id');
        $this->primaryKey(['blog_pic_id', 'user_seq']);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    // 更新日
                    'up_date' => 'always',
                    // 登録日
                    'reg_date' => 'new'
                ]
            ]
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
                ->allowEmpty('user_seq', 'create');

        $validator
                ->date('log_date')
                ->requirePresence('log_date', 'create')
                ->notEmpty('log_date');

        $validator
                ->date('up_date')
                ->requirePresence('up_date', 'create')
                ->notEmpty('up_date');

        $validator
                ->date('reg_date')
                ->requirePresence('reg_date', 'create')
                ->notEmpty('reg_date');

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
        // TODO Activate if insert restriction is not required
        /*         $rules->add($rules->existsIn(['pic_id'], 'Picture'));
          $rules->add($rules->existsIn(['album_id'], 'Album'));
          $rules->add($rules->existsIn(['weblog_id'], 'Weblog')); */

        return $rules;
    }

    /**
     * get the information of picture
     * @param string $userSeq $picId
     * @return array
     */
    public function getSingleBlogPicData($userSeq, $picId)
    {
        $picSelect = $this->find()
                ->where(['user_seq' => $userSeq,
                    'pic_id' => $picId])
                ->hydrate(false)
                ->toArray();
        return $picSelect;
    }
}
