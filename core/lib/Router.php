<?php
/**
 * Created by PhpStorm.
 * User: nassar
 * Date: 10/08/18
 * Time: 03:05
 */

/**
 * ============================================
 *  Router class
 * ============================================
 * this class responsible to route
 * uri to action (controller)
 * =============================================
 */
class Router
{
    private static $url;
    private static $method;
    private static $action;
    private static $argument = [];
    public $routes = [];

    public function __construct()
    {

    }

    /**
     * Implement HTTP GET method in routing
     * @param $url
     * @param $action
     * @param bool $protected
     */
    public function get($url, $action, $protected = false)
    {
        array_push($this->routes, ["url" => $url, "method" => "GET", "action" => "$action", "protected" => $protected]);
    }

    /**
     * Implement HTTP POST method in routing
     * @param $url
     * @param $action
     * @param bool $protected
     */
    public function post($url, $action, $protected = false)
    {
        array_push($this->routes, ["url" => $url, "method" => "POST", "action" => "$action", "protected" => $protected]);


    }

    /**
     * Implement HTTP PUT method in routing
     * @param $url
     * @param $action
     * @param bool $protected
     */

    public function put($url, $action, $protected = false)
    {
        array_push($this->routes, ["url" => $url, "method" => "PUT", "action" => "$action", "protected" => $protected]);

    }

    /**
     * Implement HTTP DELETE method in routing
     * @param $url
     * @param $action
     * @param bool $protected
     */

    public function delete($url, $action, $protected = false)
    {
        array_push($this->routes, ["url" => $url, "method" => "DELETE", "action" => "$action", "protected" => $protected]);

    }

    public function run()
    {
//        var_dump($this->routes);
        $this->findURL($this->routes);
        $this->route();
    }

    private function findURL($routes)
    {

        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$url = $_SERVER['REQUEST_URI'];
        self::$action = "";
        foreach ($routes as $route) {
            if (self::$method == $route['method']) {
                $patternAsRegex = $this->getRegex($route['url']);
                if ($ok = preg_match($patternAsRegex, self::$url, $matches)) {
                    self::$argument = array_intersect_key(
                        $matches,
                        array_flip(array_filter(array_keys($matches), 'is_string'))
                    );
                    self::$action = $route['action'];
                    /**
                     * Auth Checker
                     */

                    if ($route['protected']) {
                        $check_token = new AuthController();
                        $check_token = $check_token->check_auth();
                        if (!$check_token) {
                            $this->erroe401();
                        }
                    }
                    break;
                }
            }
        }
        if (self::$action == "") {
            self::error404();
        }

    }

    private function route()
    {
        $action_params = explode(".", self::$action);
        self::loadController($action_params[0], $action_params[1]);
    }

    private function loadController($ctrl_class, $action)
    {

        if (!file_exists(BASE_PATH . DS . "application" . DS . "controllers" . DS . $ctrl_class . ".php")) {

            $this->error404();
        } else {
            $controller = new $ctrl_class();
            $params = "";
            foreach (self::$argument as $key => $value) {
                $params .= $value . ",";
            }
            $params = rtrim($params, ",");
            $controller->{$action}($params);
        }
    }

    private function error404()
    {
        echo JsonOutput::convert(["error" => "Not Found Request"], 404);
        die();
    }


    private function erroe401()
    {
        echo JsonOutput::convert(["error" => "Unauthorized Request"], 401);
        die();

    }

    function getRegex($pattern)
    {
        if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern))
            return false; // Invalid pattern

        // Turn "(/)" into "/?"
        $pattern = preg_replace('#\(/\)#', '/?', $pattern);

        // Create capture group for ":parameter"
        $allowedParamChars = '[a-zA-Z0-9\_\-]+';
        $pattern = preg_replace(
            '/:(' . $allowedParamChars . ')/',   # Replace ":parameter"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        // Create capture group for '{parameter}'
        $pattern = preg_replace(
            '/{(' . $allowedParamChars . ')}/',    # Replace "{parameter}"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        // Add start and end matching
        $patternAsRegex = "@^" . $pattern . "$@D";

        return $patternAsRegex;
    }

}
