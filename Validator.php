<?php
class Validator
{
    private $errors;

    private function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $attributes
     * @param array $rules
     *
     * @return mixed
     */
    public function make($params, $rules)
    {
        $errors = [];

        if(is_array($params) && is_array($rules)) {
            foreach($rules as $fieldName=>$value) {
                $fieldRules = explode("|", $value);
                foreach($fieldRules as $rule) {
                    $ruleValue = $this->getRuleString($rule);
                    $rule = $this->removeRuleSuffix($rule);
                    if(method_exists($this, $rule)) {
                        $returns = $this->$rule($params, $fieldName, $ruleValue);
                        if($returns) {
                            $errors[$fieldName][$rule] = ucfirst($fieldName) . $returns;
                        }
                    } else {
                        $errors[$fieldName][$rule] = "no such a rule";
                    }
                }   
            }
        }
        $this->setErrors($errors);
    }

    protected function required($input, $fieldName, $value) 
    {
        if ($input[$fieldName] == "" || empty($input[$fieldName])) {
            return " field required";
        } else {
            return false;
        }
    }

    protected function getRuleString($rules) 
    {
        $rulesArray = explode(":", $rules);

        return isset($rulesArray[1]) ? $rulesArray[1] : null;
    }

    protected function isFieldRequired($input, $fieldName) 
    {
        return $input[$fieldName] == "" || empty($input[$fieldName]);
    }

    protected function max($input, $fieldName, $value) 
    {
        if(isset($input[$fieldName]) && strlen($input[$fieldName]) > $value) {
            return " max message";
        } else {
            return false;
        }
    }

    protected function email($input, $fieldName, $value) 
    {
        $email = $input[$fieldName];

        if(!empty($email) || $email != "") {
            return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : " email is not valid";
        }  else {
            return " email is not valid";
        }
    }

    protected function removeRuleSuffix($string) 
    {
        $arr = explode(":", $string);

        return $arr[0];
    }
}