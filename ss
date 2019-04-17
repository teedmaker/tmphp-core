[1mdiff --git a/src/Core/Route.php b/src/Core/Route.php[m
[1mindex 6e81e5c..7ab8392 100644[m
[1m--- a/src/Core/Route.php[m
[1m+++ b/src/Core/Route.php[m
[36m@@ -136,26 +136,27 @@[m [mclass Route[m
      * @return void[m
      */[m
     public static function group($firstArg, $secArg=null): void {[m
[31m-        $data   = is_array($firstArg)?    $firstArg: [];[m
[31m-        $method = is_callable($firstArg)? $firstArg: $secArg;[m
[31m-        $prefix = $data['prefix'] ?? '';[m
[31m-        //[m
[31m-        if(!is_callable($method)) {[m
[31m-            throw new Exception("No one method callable has been passed on group: `{$prefix}`.", 1);[m
[31m-        }[m
[31m-        self::$prefixForAGroup[] = $prefix;[m
[31m-        self::$controllerForAGroup = $data['controller'] ?? self::$controllerForAGroup;[m
[31m-        if(count($data)>1) {[m
[31m-            self::$dataForAGroup = array_merge(self::$dataForAGroup, $data);[m
[31m-            unset(self::$dataForAGroup['controller']);[m
[31m-            unset(self::$dataForAGroup['prefix']);[m
[31m-        }[m
[31m-        $method();[m
[31m-        array_pop(self::$prefixForAGroup);[m
[31m-        if(empty(self::$prefixForAGroup)) {[m
[31m-            self::$controllerForAGroup = null;[m
[31m-            self::$dataForAGroup       = [];[m
[31m-        }[m
[32m+[m[32m        new \Router\Group($firstArg, $secArg);[m[41m[m
[32m+[m[32m        // $data   = is_array($firstArg)?    $firstArg: [];[m[41m[m
[32m+[m[32m        // $method = is_callable($firstArg)? $firstArg: $secArg;[m[41m[m
[32m+[m[32m        // $prefix = $data['prefix'] ?? '';[m[41m[m
[32m+[m[32m        // //[m[41m[m
[32m+[m[32m        // if(!is_callable($method)) {[m[41m[m
[32m+[m[32m        //     throw new Exception("No one method callable has been passed on group: `{$prefix}`.", 1);[m[41m[m
[32m+[m[32m        // }[m[41m[m
[32m+[m[32m        // self::$prefixForAGroup[] = $prefix;[m[41m[m
[32m+[m[32m        // self::$controllerForAGroup = $data['controller'] ?? self::$controllerForAGroup;[m[41m[m
[32m+[m[32m        // if(count($data)>1) {[m[41m[m
[32m+[m[32m        //     self::$dataForAGroup = array_merge(self::$dataForAGroup, $data);[m[41m[m
[32m+[m[32m        //     unset(self::$dataForAGroup['controller']);[m[41m[m
[32m+[m[32m        //     unset(self::$dataForAGroup['prefix']);[m[41m[m
[32m+[m[32m        // }[m[41m[m
[32m+[m[32m        // $method();[m[41m[m
[32m+[m[32m        // array_pop(self::$prefixForAGroup);[m[41m[m
[32m+[m[32m        // if(empty(self::$prefixForAGroup)) {[m[41m[m
[32m+[m[32m        //     self::$controllerForAGroup = null;[m[41m[m
[32m+[m[32m        //     self::$dataForAGroup       = [];[m[41m[m
[32m+[m[32m        // }[m[41m[m
     }[m
 [m
     public static function rule(string $name, string $regex) {[m
