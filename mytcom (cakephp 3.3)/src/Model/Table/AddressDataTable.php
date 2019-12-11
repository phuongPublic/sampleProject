<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;
use Cake\Log\Log;

/**
 * AddressData Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\AddressData get($primaryKey, $options = [])
 * @method \App\Model\Entity\AddressData newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AddressData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AddressData|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AddressData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AddressData[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AddressData findOrCreate($search, callable $callback = null)
 */
class AddressDataTable extends Table
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

        $this->table('address_data');
        $this->displayField('adrdata_seq');
        $this->primaryKey('adrdata_seq');
        // update・insert column auto.
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    // 更新日
                    'upd_date' => 'always',
                    // 登録日
                    'ins_date' => 'new'
                ]
            ]
        ]);
        $this->addBehavior('LogMessage');
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
                ->integer('adrdata_seq')
                ->allowEmpty('adrdata_seq', 'create');

        $validator
                ->requirePresence('user_seq', 'create')
                ->notEmpty('user_seq');

        $validator
                ->allowEmpty('name_l');

        $validator
                ->allowEmpty('name_f');

        $validator
                ->allowEmpty('nickname');

        $validator
                ->allowEmpty('email');

        $validator
                ->allowEmpty('org_name');

        $validator
                ->allowEmpty('org_post');

        $validator
                ->allowEmpty('work_countory');

        $validator
                ->allowEmpty('work_postcode');

        $validator
                ->allowEmpty('work_pref');

        $validator
                ->allowEmpty('work_adr1');

        $validator
                ->allowEmpty('work_adr2');

        $validator
                ->allowEmpty('work_tel');

        $validator
                ->allowEmpty('work_fax');

        $validator
                ->allowEmpty('work_url');

        $validator
                ->allowEmpty('home_countory');

        $validator
                ->allowEmpty('home_postcode');

        $validator
                ->allowEmpty('home_pref');

        $validator
                ->allowEmpty('home_adr1');

        $validator
                ->allowEmpty('home_adr2');

        $validator
                ->allowEmpty('home_cell');

        $validator
                ->allowEmpty('home_tel');

        $validator
                ->allowEmpty('home_fax');

        $validator
                ->allowEmpty('home_url');

        $validator
                ->allowEmpty('birthday');

        $validator
                ->allowEmpty('note');

        $validator
                ->dateTime('ins_date')
                ->allowEmpty('ins_date');

        $validator
                ->dateTime('upd_date')
                ->allowEmpty('upd_date');

        return $validator;
    }

    /**
     * Get all address insida a group
     *
     * @param string $userSeq  User sequence
     * @param int    $groupId  Group ID
     * @return array address list
     * @return null if error
     */
    public function getAllAddressInGroup($userSeq, $groupId)
    {
        if(is_array($groupId)) {
            $groupId = "";
        }
        try {
            $addressList = $this->find()
                    ->where(['user_seq' => $userSeq, 'group_id' => $groupId])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();
            return ($addressList) ? $addressList : null;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  Get address data list in group by keyword
     *
     *  @param  string  $userSeq            user_seq
     *  @param  int     $groupId            group_id
     *  @param  int     $category           1->nickname, 2->email
     *  @param  string  $categoryKeyword   search keyword
     *  @return array   address list (null if error occurs)
     */
    public function getAddressInGroupByKeyword($userSeq, $groupId, $category, $categoryKeyword = "")
    {
        if(is_array($groupId)) {
            $groupId = "";
        }
        if(is_array($categoryKeyword)) {
            $categoryKeyword = "";
        }
        try {
            $categoryKeyword = '%' . $categoryKeyword . '%';
            if ($category == 1) {
                $whereArray = ['email LIKE' => $categoryKeyword];
            } elseif ($category == 2) {
                $whereArray = ['nickname LIKE' => $categoryKeyword];
            }

            $addressList = $this->find()
                    ->where(['user_seq' => $userSeq,
                        'group_id' => $groupId,
                        $whereArray])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();

            return (isset($addressList)) ? $addressList : 0;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get the largest Address Id and make new address Id
     *
     * @param string $userSeq User sequence
     * @return int $addressId The largest address id plus 1
     * @return int 1          If there is not any address in DB
     */
    public function createNewAddressId($userSeq)
    {
        try {
            $query = $this->find();
            $addressId = $query->select(['largestId' => $query->func()->max('adrdata_seq')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->first();
            return $addressId['largestId'] + 1;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get list of pair of address and email
     *
     * @param string $userSeq
     * @param int $groupId
     * @param string $keyword
     * @return $addressList
     */
    public function getAddressAndMail($userSeq, $groupId = null, $keyword = "")
    {
        if(is_array($groupId)) {
            $groupId = "";
        }
        if(is_array($keyword)) {
            $keyword = "";
        }
        try {
            $keyword = '%' . $keyword . '%';

            $whereArray = array(['user_seq' => $userSeq]);
            if (!empty($groupId)) {
                $whereArray[] = ['group_id' => $groupId];
            }

            $addressList = $this->find()
                    ->select(['adrdata_seq',
                        'nickname',
                        'email'])
                    ->where([$whereArray])
                    ->andWhere(['OR' => [['nickname LIKE' => $keyword],
                            ['email LIKE' => $keyword],
                            ['name_l LIKE' => $keyword],
                            ['name_f LIKE' => $keyword],
                            ['org_name LIKE' => $keyword]]])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();
            return $addressList;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get email list
     *
     * @param string    $userSeq
     * @param int       $adrId
     * @return string
     * @throws Exception
     */
    public function getUserMailFromAddressData($userSeq, $adrId)
    {
        if(is_array($adrId)) {
            $adrId = "";
        }
        try {
            $query = $this->find();
            $email = $query->select(['email', 'nickname'])
                    ->where(['user_seq' => $userSeq,
                        'adrdata_seq' => $adrId])
                    ->hydrate(false)
                    ->first();
            return $email['nickname'] . "<" . $email['email'] . ">";
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  Get address data
     *
     *  @param  int     $addressID       adrdata_seq
     *  @return array   address data(1 if error occurs)
     */
    public function getAddressData($addressID)
    {
        try {
            if (!is_numeric($addressID)) {
                $addressID = 0;
            }

            $query = $this->find()
                    ->where(['adrdata_seq' => $addressID])
                    ->hydrate(false);
            $addressData = $query->toArray();

            return (!empty($addressData)) ? $addressData[0] : null;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  count the number of address data by user_seq
     *
     *  @param  string  $userSeq     user_seq
     *  @return int  $count: number address data of user
     */
    public function getAddressSequence($userSeq)
    {
        try {
            $query = $this->find();
            $addressQuantity = $query->select(['count' => $query->func()->count('adrdata_seq')])
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();

            return $addressQuantity[0]['count'];
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  get address data list from all for search
     *
     *  @param  string   $userSeq    user_seq
     *  @param  string   $categoryKeyword          input value
     *  @param  int      $category
     *  @return int      0(null if error occurs)
     */
    public function getAddressDataBySearchKeyword($userSeq, $category, $categoryKeyword)
    {
        if(is_array($categoryKeyword)) {
            $categoryKeyword = "";
        }
        $categoryKeyword = str_replace(array("\\", "%", "_"), array("\\\\", "\%", "\_"), $categoryKeyword);
        try {
            $categoryKeyword = '%' . $categoryKeyword . '%';
            if ($category == 1) {
                $whereArray = ['email LIKE' => $categoryKeyword];
            } elseif ($category == 2) {
                $whereArray = ['nickname LIKE' => $categoryKeyword];
            }

            $addressData = $this->find()
                    ->where(['user_seq' => $userSeq, $whereArray])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();

            return (!empty($addressData)) ? $addressData : null;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  get all of address data
     *
     *  @param  string  $userSeq          user_seq
     *  @param  string  $categoryKeyword  input value
     *  @return array   address data (null if error occurs)
     */
    public function getAddressDataList($userSeq, $categoryKeyword = "")
    {
        if(is_array($categoryKeyword)) {
            $categoryKeyword = "";
        }
        try {
            $categoryKeyword = '%' . $categoryKeyword . '%';
            $addressList = $this->find()
                    ->select(['adrdata_seq',
                        'nickname',
                        'email',
                        'work_tel',
                        'home_cell',
                        'home_tel',
                        'org_name'])
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['OR' => [['nickname LIKE' => $categoryKeyword],
                            ['email LIKE' => $categoryKeyword],
                            ['work_tel LIKE' => $categoryKeyword],
                            ['home_cell LIKE' => $categoryKeyword],
                            ['home_tel LIKE' => $categoryKeyword],
                            ['org_name LIKE' => $categoryKeyword]]])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();

            return $addressList;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     *  Get all of address sequence
     *
     *  @param  string  $userSeq     user_seq
     *  @return array   $addrSeqList List of address seq
     *  @return null if error occurs
     */
    public function getAllAddressSeq($userSeq)
    {
        try {
            $query = $this->find();
            $addressData = $query->where([
                        'user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();

            if ($addressData) {
                foreach ($addressData as $address) {
                    $addrSeqList[] = $address['adrdata_seq'];
                }
                return $addrSeqList;
            } else {
                $this->logMessage('01022', $userSeq);
                return null;
            }
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            throw $e;
        }
    }

    /**
     * Get address that is in group
     *
     * @param string $userSeq user_seq
     * @param int    $groupId group id
     * @return array List of address
     *         int 1 Failed
     */
    public function getGroupAddressAndNotGroup($userSeq, $groupId = 0)
    {
        if(is_array($groupId)) {
            $groupId = 0;
        }
        try {
            $query = $this->find();
            $addressList = $query->select(['adrdata_seq', 'email', 'nickname', 'group_id'])
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['OR' => [['group_id' => $groupId],
                            ['group_id' => 0],
                            ['group_id is null']]])
                    ->orderAsc('nickname')
                    ->hydrate(false)
                    ->toArray();

            $data = array();
            $count = 0;
            foreach ($addressList as $value) {
                $data[$count] = $value;
                $data[$count]['checked'] = ($value['group_id'] == $groupId) ? 1 : "";
                $count++;
            }
            return $data;
        } catch (Exception $e) {
            $this->logMessage('01022', $userSeq);
            return 1;
        }
    }

}
