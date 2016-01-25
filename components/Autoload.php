<?php

spl_autoload_register(function ($class) {
    include ROOT . '\\' . $class . '.php';
});
