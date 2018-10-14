<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 21:21
 */


class RatingValidator
{
    public function validate($input)
    {
        $Validator = new Valitron\Validator($input);
        $Validator->rule('max', 'rate', 5);
        return $Validator->validate();
    }

    public function validate_id($id)
    {
        $Validator = new Valitron\Validator(["id" => $id]);
        $Validator->rule('integer', ['id']);
        return $Validator->validate();

    }
}