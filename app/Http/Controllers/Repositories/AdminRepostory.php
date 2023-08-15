<?php
/**
 * Created by PhpStorm.
 * User: Basem
 * Date: 12/22/2020
 * Time: 2:11 AM
 */
namespace App\Http\Repositories;

use App\Admin;
use App\Http\Interfaces\AdminRepostoryInterface;

class AdminRepostory implements AdminRepostoryInterface {
    public function All()
    {
        // TODO: Implement All() method.
        $user = Admin::all();
        return $user;
    }
}