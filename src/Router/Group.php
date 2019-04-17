<?php

namespace Router;

class Group
{
    private $data = [];
    private $prefix = [];
    private $method = null;
    private $controller = null;

    /**
     * a method to call various others methods as child.
     *
     * @param array|calllable $firstArg
     * @param callable|null   $secArg
     */
    public function __construct($firstArg, $secArg=null) {
        $data   = is_array($firstArg)? $firstArg: [];
        $this->setCallable($firstArg, $secArg);
        $this->prefix[] = $data['prefix'] ?? '';
        $this->controller = $data['controller'] ?? $this->controller;
        if(count($data)>1) {
            $this->data = array_merge($this->data, $data);
            unset($this->data['controller']);
            unset($this->data['prefix']);
        }
    }

    /**
     * Set the callable from this group, if no have, return a throw
     *
     * @param [type] $firstArg
     * @param [type] $secArg
     * @return void
     */
    public function setCallable($firstArg, $secArg) {
        $this->callable = is_callable($firstArg)? $firstArg: $secArg;
        if(!is_callable($this->callable)) {
            throw new Exception("No one callable has been passed in the group.", 1);
        }
    }

    public function __destruct() {
        // execute the callable
        $this->callable();
        // removes the last prefix
        array_pop($this->prefix);
        // if no have more prefix, it's end
        if(empty($this->prefix)) {
            $this->controller = null;
            $this->data       = [];
        }
    }

}
