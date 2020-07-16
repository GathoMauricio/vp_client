<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRol;
use App\Customer;
use App\Service;
use App\ServiceType;
use App\Comment;
use App\Http\Requests\ServiceRequest;
use Auth;
use DB;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(getRoles()['rol_admin'])
        {
            $services = Service::whereDate('schedule', Carbon::today())
            ->paginate(15);
            return view('services/index_service',['services'=>$services,'rol'=>'Administrador']);
        }
        if(getRoles()['rol_mesa'] && getRoles()['rol_tec'])
        {
            $services = Service::whereDate('schedule', Carbon::today())->
                where('manager_id',Auth::user()->id)
            ->orWhere('technical_id',Auth::user()->id)
            ->paginate(15);
            return view('services/index_service',['services'=>$services,'rol'=>'Mesa de ayuda + Técnico']);
        }
        if(getRoles()['rol_mesa'])
        {
            $services = Service::whereDate('schedule', Carbon::today())->
            where('manager_id',Auth::user()->id)->paginate(15);
            return view('services/index_service',['services'=>$services,'rol'=>'Mesa de ayuda']);
        }
        if(getRoles()['rol_tec'])
        {
            $services = Service::whereDate('schedule', Carbon::today())->
            where('technical_id',Auth::user()->id)->paginate(15);
            return view('services/index_service',['services'=>$services,'rol'=>'Técnico']);
        }
        $services = Service::whereDate('schedule', Carbon::today())->
        where('technical_id',0)->paginate(15);
        return view('services/index_service',['services'=>$services,'rol'=>'Sin roles']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $servicesTypes = ServiceType::all();
        //$technicals = User::where('user_type_id',3)->get();//El id 3 son los técnicos
        //$technicals = User::all();
        $customers = Customer::all();
        return view('services/create_service',
            [
                'servicesTypes' => $servicesTypes,
                //'technicals' => $technicals,
                'customers' => $customers
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        //return dd($request);
        $service = Service::create(
            $request->all()+
            [
                'service_report' => 'VP/'.date('mdHis'),
                'schedule' => $request->schedule_fecha.' '.$request->schedule_hora.':00'
            ]
        );
        if($service)
        {
            return redirect('show_service/'.$service->id)->with('mensaje','El servicio se creó con éxito.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        $comments = Comment::where('service_id',$id)->orderBy('created_at','desc')->get();
        return view('services/show_service',[
            'service'=>$service,
            'comments'=>$comments
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loadEmployees(Request $request)
    {
        if(!empty($request->value))
        {
            $empleados = DB::select("
            SELECT * FROM users u LEFT JOIN users_roles ur 
            ON u.id = ur.user_id 
            LEFT JOIN roles r 
            ON r.id = ur.rol_id 
            WHERE r.id = '$request->value'
            ");
            $html="<option value>--Seleccione una opción--</option>";
            for($i=0;$i<count($empleados);$i++)
            {
                $html.="<option value='".$empleados[$i]->user_id."'>".$empleados[$i]->name." ".$empleados[$i]->last_name1." ".$empleados[$i]->last_name2."</option>";
            }
            return $html;
        }else{
            return "<option value>--Seleccione una opción--</option>";
        }
    }

    public function loadFinalUsers(Request $request)
    {
        if(!empty($request->value))
        {
            $finalUsers = DB::select("
            SELECT * FROM final_users WHERE customer_id = ".$request->value."
            ");
            $html="<option value>--Seleccione una opción--</option>";
            for($i=0;$i<count($finalUsers);$i++)
            {
                $html.="<option value='".$finalUsers[$i]->id."'>".$finalUsers[$i]->name."</option>";
            }
            return $html;
        }else{
            return "<option value>--Seleccione una opción--</option>";
        }
    }
    public function printSErviceFormat(Request $request,$id)
    {
        $service = Service::findOrFail($id);
        //return view('pdf.servicio',['service'=>$service]);
        $pdf = \PDF::loadView('pdf.servicio',['service'=>$service]);
        return $pdf->download('servicio_'.$service->service_report.'.pdf');
    }
}
