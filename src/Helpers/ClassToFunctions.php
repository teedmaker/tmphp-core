<?php

function view() {
    return call_user_func_array(new View, func_get_args());
}
