<?php

namespace App\Modules\System;

use App\Exports\ActivityExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Auth;
use  App\Models\ImporterData;
use  App\Models\Importer;
use  App\Models\LeadData;
use  App\Models\PropertyParameter;
use  App\Models\RequestParameter;
use Maatwebsite\Excel\Facades\Excel;
use Jenssegers\Agent\Agent;

class ActivityController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isDataTable) {
            $eloquentData = Activity::with( ['subject', 'causer'] )
                ->select( [
                    'id',
                    'log_name',
                    'description',
                    'subject_id',
                    'subject_type',
                    'causer_id',
                    'causer_type',
                    'created_at',
                    'updated_at',
                    'properties'
                ] )->whereNotNull('causer_id')->whereHas( 'causer' );
//dd($eloquentData->toSql());
            $value = isset( $request->all()['columns'] ) ? $request->all()['columns'][0]['search']['value'] : null;
            if (!is_null( $value )) {
                $eloquentData = $eloquentData->whereHas( 'causer', function ($query) use ($request, $value) {

                    $query->where( 'name', 'LIKE', '%' . $value . '%' );
                } );
            }

            whereBetween( $eloquentData, 'DATE(created_at)', $request->created_at1, $request->created_at2 );

            if ($request->id) {
                $eloquentData->where( 'id', '=', $request->id );
            }

            if ($request->status) {
                $eloquentData->where( 'description', '=', $request->status );
            }

            if ($request->subject_type) {
                $eloquentData->where( 'subject_type', '=', $request->subject_type );
            }

            if ($request->subject_id) {
                $eloquentData->where( 'subject_id', '=', $request->subject_id );
            }

            if ($request->causer_type) {
                $eloquentData->where( 'causer_type', '=', $request->causer_type );
            }

            if ($request->causer_id) {
                $eloquentData->where( 'causer_id', '=', $request->causer_id );
            }


            if ($request->downloadExcel == "true") {
                $excelData = $eloquentData;
                $excelData = $excelData->get();

                $name = date( 'd-m-Y' ) . '-' . setting( 'company_name' ) . ' Audit trail';
                return exportXLS($name,[
                    __( 'Created At' ),
                    __( 'User' ),
                    __( 'Actions' ),
                    __( 'Parameters' )
                ],$excelData,
                [
                    'created_at'=>function($one){
                       return $one->created_at->format('Y-m-d h:i:s');
                    },
                    'user'=>function($one){
                    return optional($one->causer)->fullname;
                    },
                    'actions'=>function($data){
                        return $data->description . ' ' . str_replace( 'App\Models\\', '', $data->subject_type );
                    },
                    'parameters'=>function($data){
                        $string= ' ';
                        if ( $data->subject_type == 'App\\Models\\PermissionGroup'){
                            return $string = 'name '.$data->properties['name'];
                        }
                        if ($data->description == 'updated') {
                            $keys = array_keys( $data->properties['attributes'] );
                            foreach ($keys as $value) {
                                $string .=$value.' '.$data->properties['old'][$value] .' changed to '.$data->properties['attributes'][$value];
                                $string .='<br/>';
                            }
                            return  $string;
                        }
                        if ($data->description == 'created') {
                            if ( $data->subject_type == 'App\Models\PermissionGroup'){
                                $string = 'name:';
                            }

                            $keys = array_keys( $data->properties['attributes'] );

                            foreach ($keys as $value) {
                                $string .=$value.' '.$data->properties['attributes'][$value];
                                $string .='<br/>';
                            }

                            return  $string;
                        }
                    }
                ]
                );
//                return view( 'system.exports.activity', [
//                    'data' => $excelData
//                ] );
//                return Excel::download( new ActivityExport( $excelData ), $name . '.xlsx' );
//                $pdf = PDF::loadView('system.exports.activity', ['data'=>$excelData]);
//
//                return $pdf->download($name.'.pdf');
            }


            return \Datatables::of( $eloquentData )
                ->addColumn( 'created_at', function ($data) {
                    return $data->created_at->format( 'Y-m-d h:i:s' );
                } )
                ->addColumn( 'causer', function ($data) {
                    if ($data->causer) {
                        return '<a target="_blank" href="' . route( 'system.staff.show', $data->causer->id ) . '">' . $data->causer->fullname . '</a>';
                    }

                } )
                ->addColumn( 'description', function ($data) {
                    return $data->description . ' ' . str_replace( 'App\Models\\', '', $data->subject_type );
                } )
                ->addColumn( 'action', function ($data) {
                    $string= ' ';
                    if ( $data->subject_type == 'App\\Models\\PermissionGroup'){
                       return $string = 'name '.$data->properties['name'];
                    }
                    if ($data->description == 'updated') {
                        $keys = array_keys( $data->properties['attributes'] );
                        foreach ($keys as $value) {
                            $string .=$value.' '.$data->properties['old'][$value] .' changed to '.$data->properties['attributes'][$value];
                            $string .='<br/>';
                        }
                        return  $string;
                    }
                    if ($data->description == 'created') {
                        if ( $data->subject_type == 'App\Models\PermissionGroup'){
                            $string = 'name:';
                        }

                        $keys = array_keys( $data->properties['attributes'] );

                        foreach ($keys as $value) {
                            $string .=$value.' '.$data->properties['attributes'][$value];
                            $string .='<br/>';
                        }

                        return  $string;
                    }
//                    return str_replace( 'App\Models\\', '', $data->subject_type );
//                    return $data->subject_type . ' (' . $data->subject_id . ')';
                } )

//                ->addColumn('action',function($data){
//                    return '<a class="dropdown-item" href="javascript:void(0);" onclick="urlIframe(\''.route('system.activity-log.show',$data->id).'\')"><i class="fa fa-eye"></i> '.__('View').'</a>';
//                })

                ->escapeColumns( [] )
                ->make( true );
        } else {

            // View Data
            $this->viewData['tableColumns'] = [
//                __('ID'),
                __( 'Created At' ),
                __( 'User' ),
                __( 'Actions' ),
//                __('Model ID'),
                __( 'Parameters' )
            ];

            $this->viewData['js_columns'] = [
                'created_at' => 'activity_log.created_at',
                'causer' => 'causer',
                'description' => 'activity_log.description',
//                'subject'=>'activity_log.subject_type',
                'action' => 'action'
            ];


            $this->viewData['filter'] = true;
            $this->viewData['download_excel'] = true;

            $this->viewData['breadcrumb'][] = [
                'text' => __( 'Audit trail' )
            ];
            $this->viewData['pageTitle'] = __( 'Audit trail' );


            return $this->view( 'activity-log.index', $this->viewData );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($ID)
    {
        $result = Activity::findOrFail( $ID );
        $agent = new Agent();
        $agent->setUserAgent( $result->user_agent );
        $result->agent = $agent;
        $location = @json_decode( file_get_contents( 'http://ip-api.com/json/' . $result->ip ) );
//        if($location->status!='fail')
//            $result->location = $location;


        $this->viewData['result'] = $result;
        return $this->view( 'activity-log.show', $this->viewData );
    }

}
