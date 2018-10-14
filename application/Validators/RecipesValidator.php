<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 12/08/18
 * Time: 21:21
 */


class RecipesValidator
{
    public function validate($input)
    {
        $Validator = new Valitron\Validator($input);
        $Validator->rule('required', ['name', 'prep_time', 'difficulty', 'vegetarian']);
        $Validator->rule('integer', ['prep_time', 'difficulty', 'vegetarian']);
        $Validator->rule('max', 'difficulty', 3);
        $Validator->rule('max', 'vegetarian', 1);
        return $Validator->validate();
    }

    public function validate_id($id)
    {
        $Validator = new Valitron\Validator(["id" => $id]);
        $Validator->rule('integer', ['id']);
        return $Validator->validate();

    }
}