<?php

function view($path, $args=[]) {
    return new View($path, $args);
}
