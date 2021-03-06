<?php
namespace components;

class Config
{
    public static function getDbParams()
    {
        return array(
            'host' => 'localhost',
            'db_name' => 'guestbook',
            'user' => 'syomushkin',
            'password' => '26041989smn'
        );
    }

    public static function getRoutes()
    {
        return array(
            'user/logout' => 'user/logout', //actionLogout in UserController
            'user' => 'user/register', //actionRegister in UserController
            'home' => 'home/index' //actionIndex in HomeController
        );
    }
}
