<?php

/**
 * Class to manipulate view
 */
class View
{
    private $path = '';
    private $data = [];

    /**
     * Initialize View class
     *
     * @param string $path: the path to view
     * @param array $data: the data to send to view
     * @return View
     */
    public function __construct(string $path, array $data=[]) {
        $path = str_replace('.', '/', $path);
        $this->path = $path;
        $this->data = $data;
        return $this;
    }

    /**
     * Add variables to send to view
     *
     * @param string $name
     * @param void $value
     * @return View
     */
    public function with(string $name, $value) {
        $this->data['view'][$name] = $value;
        return $this;
    }

    /**
     * Set title to the template
     *
     * @param string $value
     * @return void
     */
    public function title(string $title) {
        $this->data['template']['title'] = $title;
        return $this;
    }
}
