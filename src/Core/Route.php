<?php

class Route
{
    protected static $routes = [
        'get'    => [],
        'post'   => [],
        'put'    => [],
        'delete' => []
    ];
    protected static $prefixForAGroup     = [];
    protected static $dataForAGroup       = [];
    protected static $controllerForAGroup = null;
    protected static $regexOptions        = null;

    /**
     * finding actual route
     *
     * @return void
     */
    public static function findActualRoute() {
        $routes = self::$routes[METHOD];
        $route  = $routes[BRANCH] ?? null;
        if(!$route) {
            return self::searchInRoutes($routes);
        }
        self::executeARoute($route);
    }

    protected static function searchInRoutes(array $routes=[]) {
        $barsInActual = substr_count(BRANCH, '/');
        $response     = null;
        $data         = [];
        foreach($routes as $url => $route) {
            // removes first bar
            $url = trim($url, '/');
            if($url==='/' or $barsInActual!==substr_count($url, '/')) {
                continue;
            }
            $url = preg_quote($url, '/');
            if(preg_match_all('/\\\{(.*)\\\}/', $url, $matches)) {
                $url = self::replaceRegexInRouteUrl($url, $matches[1]);
            }
            if(preg_match_all("/{$url}/", BRANCH, $matches)) {
                $data     = $matches[1];
                $response = $route;
                break;
            }
        }
        if(is_null($response)) {
            return self::getNotFound();
        }
        self::executeARoute($response, $data);
    }

    protected static function replaceRegexInRouteUrl(string $url, array $matches) {
        foreach($matches as $regex) {
            if(!isset(self::$regexOptions[$regex])) {
                throw new Exception("Regex ´{$regex}´ not found in rules for route.", 1);
            }
            $value = self::$regexOptions[$regex];
            $url   = str_ireplace("\{{$regex}\}", $value, $url);
        }
        return $url;
    }

    // configurate route not found
    protected static function getNotFound() {
        //
    }

    protected static function executeARoute(array $route, array $data=[]) {
        extract($route);
        if($method!==null) {
            return self::doMethod($method, $configs);
        }
        if(is_callable($callable)) {
            return call_user_func_array($callable, $data);
        }
        throw new Exception("The route don't have an controller or a callable function.", 1);
    }

    protected static function doMethod(string $method, array $configs) {
        if(!preg_match('/\@/', $method)) {
            throw new Exception("Actual method don't have a controller setted: `{$method}`.", 1);
        }
        call_user_func(explode('@', $method));
    }

    protected static function addAnMethod(string $type, string $url, $firstArg=null, $secArg=null): void {
        // e.g.: ExampleController@gethome
        $method = is_string($firstArg)? $firstArg: null;
        // array with informations about this route
        $configs = is_array($firstArg)? $firstArg: [];
        // callable function to run
        $callable = is_callable($firstArg)? $firstArg: (is_callable($secArg)? $secArg: null);
        //
        if(!empty($method) and !preg_match('/\@/', $method)) {
            $method = self::$controllerForAGroup ."@{$method}";
        }
        $url     = empty($url)? '/': $url;
        $configs = array_merge(self::$dataForAGroup, $configs);
        self::$routes[$type][$url] = [
            'configs'  => $configs,
            'method'   => $method,
            'callable' => $callable
        ];
    }

    /**
     * methods get|post|put|delete for any contents
     *
     * @param string $name
     * @param array $args
     * @return void
     */
    public static function __callStatic($name, $args): void {
        if(!preg_match('/get|post|put|delete/', $name)) {
            throw new Exception("Ops! An static method has been called. A method need be like: get|post|put|delete.", 1);
        }
        array_unshift($args, $name);
        if(count(self::$prefixForAGroup)) {
            $prefix = implode('/', self::$prefixForAGroup) . '/';
            $args[1] = "{$prefix}{$args[1]}";
            $args[1] = preg_replace('/(\/\/)/', '/', $args[1]);
            $args[1] = trim($args[1], '/');
        }
        call_user_func_array([new self, 'addAnMethod'], $args);
    }

    /**
     * `group` as method to call various others methods as child.
     *
     * @param array|calllable $firstArg
     * @param callable|null   $secArg
     * @return void
     */
    public static function group($firstArg, $secArg=null): void {
        new \Router\Group($firstArg, $secArg);
        // $data   = is_array($firstArg)?    $firstArg: [];
        // $method = is_callable($firstArg)? $firstArg: $secArg;
        // $prefix = $data['prefix'] ?? '';
        // //
        // if(!is_callable($method)) {
        //     throw new Exception("No one method callable has been passed on group: `{$prefix}`.", 1);
        // }
        // self::$prefixForAGroup[] = $prefix;
        // self::$controllerForAGroup = $data['controller'] ?? self::$controllerForAGroup;
        // if(count($data)>1) {
        //     self::$dataForAGroup = array_merge(self::$dataForAGroup, $data);
        //     unset(self::$dataForAGroup['controller']);
        //     unset(self::$dataForAGroup['prefix']);
        // }
        // $method();
        // array_pop(self::$prefixForAGroup);
        // if(empty(self::$prefixForAGroup)) {
        //     self::$controllerForAGroup = null;
        //     self::$dataForAGroup       = [];
        // }
    }

    public static function rule(string $name, string $regex) {
        self::$regexOptions[$name] = $regex;
    }
}
