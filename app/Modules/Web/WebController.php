<?php

namespace App\Modules\Web;

use App\Http\Controllers\Controller;
use App\Models\Adv;
use App\Models\Blog;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\Measurement;
use App\Models\Opnion;
use App\Models\Project;
use App\Models\Sensor;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;


class WebController extends Controller
{

    protected $viewData = [];


    public function index()
    {
        return redirect()->route( 'system.dashboard' );
        return view( 'web.index' );
    }




}
