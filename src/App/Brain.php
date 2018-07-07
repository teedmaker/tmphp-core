<?php

namespace TMPHP\App;

class Brain
{
    public static function init() {
        $rota = BRANCH? BRANCH: 'em branco';
        $host = HOST;

        echo "Rota aual: {$rota} <br/> <br/>";

        echo "Experimente ir para:  <br/> <br/>";
        echo "<a href=\"{$host}teste\">teste</a> <a href=\"{$host}users/teedmaker\">users/teedmaker</a> ";
    }
}
