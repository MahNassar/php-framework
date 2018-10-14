<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 11/08/18
 * Time: 15:31
 */

class RateController extends Controller
{
    public function __construct()
    {

        $this->model = new RateModel();
    }

    public function rate($id)
    {
        $input = RequestHandler::get_request_body();
        $validator = new RatingValidator();
        $idValidator = $validator->validate_id($id);
        $inputValidator = $validator->validate($input);
        if ($idValidator && $inputValidator) {
            $input['recipe_id'] = $id;
            $rate = $this->model->insert($input);
            echo JsonOutput::convert($rate, 201);
        } else {
            echo Responses::bad_request();
        }
    }
}