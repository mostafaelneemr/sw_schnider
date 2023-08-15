<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function response($status, $code = '200', $message = 'Done', $data = []): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
    protected function getApp(){

       return App::where('token',request()->header('token'))->value('id');
    }

}
