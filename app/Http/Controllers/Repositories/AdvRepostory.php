<?php
/**
 * Created by PhpStorm.
 * User: Basem
 * Date: 12/22/2020
 * Time: 2:11 AM
 */
namespace App\Modules\Repositories;

use App\Modules\Interfaces\AdvRepostoryInterface;
use App\Models\Adv;
use http\Env\Request;
use Yajra\DataTables\DataTables;

class AdvRepostory implements AdvRepostoryInterface {
    public function All()
    {
        $adv = Adv::all();
        return $adv ;
    }

    public function save(Adv $adv, $request , $path = null)
    {

        $image='';
        if ($request->image !=null){
            $image = Uploadimage($path,$request->hasFile('image'),$request->image,'app/adv/','Adv','adv',$path);
        }
        if ($image != '') {
            $adv->image = $image;
        }
        $adv->save();
        if ($adv->save()) {
            return true;
        } else {
            return false;
        }

        return false;
    }

}