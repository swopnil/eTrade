<?php


namespace App\Classes;


use Illuminate\Database\Capsule\Manager as Capsule;

class ValidateRequest
{
    private static $error = [];
    private static $error_messages = [
        'string' => 'The :attribute field cannot contain numbers',
        'required' => 'The :attribute field is required',
        'minLength' => 'The :attribute field must be a minimum of :policy characters',
        'maxLength' => 'The :attribute field must be a maximum of :policy characters',
        'mixed' => 'The :attribute field can contain letters, numbers, dash and space only',
        'number' => 'The :attribute field cannot contain letters e.g. 20.0, 20',
        'email' => 'Email address is not valid',
        'unique' => 'That :attribute is already taken, please try another one'
    ];

    /**
     *
     * @param array $dataAndValues, column ad value to validate
     * @param array $policies, the rules that validation must satisfy
     */
    public function abide(array $dataAndValues, array $policies)
    {
        foreach ($dataAndValues as $column => $value) {
            if (in_array($column, array_keys($policies))) {
                // Do validation
                self::doValidation(
                    [
                        'column' => $column,
                        'value' => $value,
                        'policies' => $policies[$column]
                    ]
                );
            }
        }
    }

    /**
     * Perform validation for the data provider and set error messages
     * @param array $data
     */
    private static function doValidation(array $data)
    {
        $column = $data['column'];

        foreach ($data['policies'] as $rule => $policy) {
            $valid = call_user_func_array([self::class, $rule], [$column, $data['value'], $policy]);

            if (!$valid) {
                self::setError(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$column, $policy, ' '],
                        self::$error_messages[$rule]), $column
                );
            }
        }
    }

    /**
     * Check unique value
     * @param $column, field name or column
     * @param $value, value passed into te form
     * @param $policy, the rule that we set e.g min = 5
     * @return bool, true | false
     */
    protected static function unique($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            return !Capsule::table($policy)->where($column, '=', $value)->exists();
        }

        return true;
    }

    /**
     * Check empty field
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function required($column, $value, $policy)
    {
        return $value !== null && !empty(trim($value));
    }

    /**
     * Check min length
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function minLength($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            return strlen($value) >= $policy;
        }

        return true;
    }

    /**
     * Check max length
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function maxLength($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            return strlen($value) <= $policy;
        }

        return true;
    }

    /**
     * Email validate
     * @param $column
     * @param $value
     * @param $policy
     * @return bool|mixed
     */

    protected static function email($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        return true;
    }

    /**
     * Mixed [String, number] validate
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function mixed($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            if (!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * String validate only
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */

    protected static function string($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            if (!preg_match('/^[A-Za-z ]+$/', $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Number validate only
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */

    protected static function number($column, $value, $policy)
    {
        if ($value != null && !empty(trim($value))) {
            if (!preg_match('/^[0-9.]+$/', $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Set specific error
     * @param $error
     * @param null $key
     */

    private static function setError($error, $key = null)
    {
        if ($key) {
            self::$error[$key][] = $error;
        } else {
            self::$error[] = $error;
        }
    }

    /**
     * Return true if there is validation error
     * @return bool
     */

    public function hasError()
    {
        return count(self::$error) > 0 ? true : false;
    }

    /**
     * Return all validation errors
     * @return array
     */

    public function getErrorMessages()
    {
        return self::$error;
    }
}