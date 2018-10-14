<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 13/08/18
 * Time: 01:47
 */

/**
 * ======================================================
 * Routing File
 * ======================================================
 * Here is where you can register  routes for  application.
 * functions available (get,post,put,delete)
 * each function need param
 *      - url string URI of api  EX "/example"
 *      - action  string Controller name and function name
 *                     EX "controller.function"
 *      - protected Bol default = false
 * ======================================================
 * Enjoy ...
 */


$router = new Router();

/*
 * ======================================================
 * GET Token API
 * ======================================================
 * @Method : GET
 * @Return : token
 *
 * it's a fake function to generate token
 * and set it in database to auth protected request
 *
 *http status code 200
 */
$router->get("/hello/auth", "AuthController.get_token");
/*
 * =========================================================
 * GET ALL RECIPES
 * ==========================================================
 * @method : GET
 * @return : json List of recipes
 *
 *  EX :
 * [{"id":"1","name":"recipe","prep_time":"30","difficulty":"1","vegetarian":"1"}]
 *
 * this function not protected
 *
 *  *http status code 200

 */
$router->get("/hello/recipes", "RecipesController.index");
/*
 * =========================================================
 * ADD RECIPES
 * ==========================================================
 * @method : POST
 * @return : json Data
 * EX :
 * {"status":true,"error":""}
 *
 * this function  protected
 *
 * Request body is  json EX :
 * {"name":"recipe ","prep_time":"30","difficulty":"1","vegetarian":1}
 *
 * http status code 201

 */
$router->post("/hello/recipes", "RecipesController.create", true);
/*
 * =========================================================
 * GET ONE RECIPE
 * ==========================================================
 * @method : GET
 * @return : json Data
 *
 * this function not protected
 *
 * Request body is  json EX :
 * [{"id":1,"name":"recipe ","prep_time":"30","difficulty":"1","vegetarian":1}]
 *
 *  http status code 200

 */
$router->get("/hello/recipes/{id}", "RecipesController.getOne");
/*
 * =========================================================
 * UPDATE RECIPES
 * ==========================================================
 * @method : PUT
 * @return : json Data
 * EX :
 * {"status":true,"error":""}
 *
 * this function  protected
 *
 * Request body is  json EX :
 * {"name":"recipe ","prep_time":"30","difficulty":"1","vegetarian":1}
 *
 * http status code 202
 */
$router->put("/hello/recipes/{id}", "RecipesController.update", true);
/*
 * =========================================================
 * DELETE RECIPES
 * ==========================================================
 * @method : DELETE
 * @return : json Data
 * EX :
 * {"status":true,"error":""}
 *
 * this function  protected
 *
 * http status code 202
 */
$router->delete("/hello/recipes/{id}", "RecipesController.delete", true);
/*
 * =========================================================
 * POST RECIPES
 * ==========================================================
 * @method : POST
 * @return : json Data
 * EX :
 * {"status":true,"error":""}
 *
 * this function  protected
 *
 * Request body is  json EX :
 * {"rate":5}
 *
 * http status code 201
 */
$router->post("/hello/recipes/{id}/rating", "RateController.rate");

$router->run();
