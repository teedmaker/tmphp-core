<?php

class View
{
    private $data = [];

    public function __construct(string $path, array $data=[]) {
        $this->path = $path;
        $this->data = $data;
        return $this;
    }

    public function with($name, $value) {
        $this->data[$name] = $value;
        return $this;
    }

    public function title($value) {
        $this->data['title'] = $value;
        return $this;
    }
}
