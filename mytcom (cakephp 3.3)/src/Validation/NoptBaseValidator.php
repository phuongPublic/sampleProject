<?php
namespace App\Validation;

use Cake\Validation\Validator;

/**
 * Validator object encapsulates all methods related to data validations for a model
 * Base on cakePHP\Validator
 * by pass in case set field is true
 */
class NoptBaseValidator extends Validator
{
    /**
     * Returns an array of fields that have failed validation. On the current model. This method will
     * actually run validation rules over data, not just return the messages.
     * @param array $data
     * @param boolean $newRecord
     * @return Validator
     */
    public function errors(array $data, $newRecord = true)
    {
        $errors = [];
        $requiredMessage = 'This field is required';
        $emptyMessage = 'This field cannot be left empty';

        if ($this->_useI18n) {
            $requiredMessage = __d('cake', 'This field is required');
            $emptyMessage = __d('cake', 'This field cannot be left empty');
        }

        foreach ($this->_fields as $name => $field) {
            $keyPresent = array_key_exists($name, $data);

            $providers = $this->_providers;
            $context = compact('data', 'newRecord', 'field', 'providers');

            if (!$keyPresent && !$this->_checkPresence($field, $context)) {
                $errors[$name]['_required'] = isset($this->_presenceMessages[$name])
                    ? $this->_presenceMessages[$name]
                    : $requiredMessage;
                continue;
            }
            if (!$keyPresent) {
                continue;
            }

            $canBeEmpty = $this->_canBeEmpty($field, $context);
            $isEmpty = $this->_fieldIsEmpty($data[$name]);

            if (!$canBeEmpty && $isEmpty) {
                $errors[$name]['_empty'] = isset($this->_allowEmptyMessages[$name])
                    ? $this->_allowEmptyMessages[$name]
                    : $emptyMessage;
                continue;
            }

            $bypass = isset($data['bypass'][$name]) ? $data['bypass'][$name] : false;
            if ($isEmpty && !$bypass) {
                continue;
            }

            $result = $this->_processRules($name, $field, $data, $newRecord);
            if ($result) {
                $errors[$name] = $result;
            }
        }

        return $errors;
    }
}
