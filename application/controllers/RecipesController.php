<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 10/08/18
 * Time: 15:42
 */


class RecipesController extends Controller
{
    public function __construct()
    {

        $this->model = new RecipeModel();
    }

    public function index()
    {
        $all_recipes = $this->model->all();
        echo JsonOutput::convert($all_recipes);
    }

    public function create()
    {
        $input = RequestHandler::get_request_body();
        $Validator = new RecipesValidator();
        $Validator = $Validator->validate($input);
        if ($Validator) {
            $recipe = $this->model->insert($input);
            echo JsonOutput::convert($recipe, 201);
        } else {
            echo Responses::bad_request();
        }
    }

    public function getOne($id)
    {
        $Validator = new RecipesValidator();
        $Validator = $Validator->validate_id($id);
        if ($Validator) {
            $query = "id=" . $id;
            $recipe = $this->model->select($query);
            echo JsonOutput::convert($recipe);
        } else {
            echo Responses::bad_request();
        }

    }

    public function update($id)
    {
        $input = RequestHandler::get_request_body();
        $validator = new RecipesValidator();
        $idValidator = $validator->validate_id($id);
        $inputValidator = $validator->validate($input);
        if ($idValidator && $inputValidator) {
            $update = $this->model->update($input, $id);
            echo JsonOutput::convert($update, 202);
        } else {
            echo Responses::bad_request();
        }

    }

    public function delete($id)
    {
        $Validator = new RecipesValidator();
        $Validator = $Validator->validate_id($id);
        if ($Validator) {
            $query = "id=" . $id;
            $output = $this->model->delete($query);
            echo JsonOutput::convert($output, 202);
        } else {
            echo Responses::bad_request();
        }

    }


}