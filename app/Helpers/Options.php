<?php

namespace App\Helpers;

class Options
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    const MALE = 'male';
    const FEMALE = 'female';
    


    public static function gender()
    {
        return [
            self::MALE => 'Male',
            self::FEMALE => 'Female',
         
        ];
    }

    public static function userStatus() {
        return [
            'Active' => 'Active',
            'Banned' => 'Banned',
            'Suspended' => 'Suspended',
        ];
    }

    public static function userTypes() {
        return [
            'admin' => 'admin',
            'super_admin' => 'super_admin',
            'agent' => 'agent',
            'agent_school' => 'agent_school',
            'user' => 'user'
        ];
    }
}
