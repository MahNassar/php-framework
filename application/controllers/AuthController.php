<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 11/08/18
 * Time: 15:57
 */

class AuthController extends Controller
{
    public function __construct()
    {
        $this->model = new AuthModel();
    }

    public function get_token()
    {
        $token_generated = md5(uniqid(rand(), true));
        $token = $this->model->insert(["token" => $token_generated]);
        if ($token['status']) {
            echo JsonOutput::convert(["token" => $token_generated]);
        } else {
            echo JsonOutput::convert([$token]);
        }

    }

    public function check_auth()
    {
        if (isset($_SERVER['HTTP_TOKEN'])) {
            $HTTP_TOKEN = $_SERVER['HTTP_TOKEN'];
            $query = "token='" . $HTTP_TOKEN . "'";

            $token = $this->model->select($query);
            if (count($token) > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

}