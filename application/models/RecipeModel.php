<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 11/08/18
 * Time: 03:22
 */

class RecipeModel extends Model
{
    public $table = "recipe";
    public $roles = [
        'name' => [
            'required',
            'alpha',
            'max_length(50)'
        ],
        'prep_time' => [
            'required',
            'integer',
        ],
        'difficulty' => [
            'required',
            'integer'
        ],
        'vegetarian' => [
            'required',
            'integer'
        ],
    ];
}