<?php

namespace App\Http\Controllers;
use App\Customer;
use App\FinalUser;
use App\Http\Requests\FinalUserRequest;
use Illuminate\Http\Request;

class FinalUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        $customer = Customer::findOrFail($id);
        return view('final_user.create_final_user',['customer'=>$customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinalUserRequest $request)
    {
        $finalUser = FinalUser::create($request->all());
        if($finalUser)
        {
            return redirect('show_final_user/'.$finalUser->id)->with('mensaje','El usuario se creó con éxito.');
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
        $finalUser = FinalUser::findOrFail($id);
        return view('final_user.show_final_user',['finalUser'=>$finalUser]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finalUser = FinalUser::findOrFail($id);
        return view('final_user.edit_final_user',['finalUser'=>$finalUser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FinalUserRequest $request, $id)
    {
        $finalUser = FinalUser::findOrFail($id);
        $finalUser->update($request->all());
        return redirect('show_final_user/'.$finalUser->id)->with('mensaje','El usuario final se actualizó con éxito.');
    }
    /**
     * confirm the specified resource before destroy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request,$id)
    {
        $finalUser = FinalUser::findOrfail($id);
        return view('final_user/confirm_final_user',['finalUser'=>$finalUser]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $finalUser = FinalUser::findOrfail($id);
        $customer_id = $finalUser->customer_id;
        if($finalUser->delete())
        {
            return redirect('show_customer/'.$customer_id)->with('mensaje','El usuario final se eliminó con éxito.');
        }else{
            return $finalUser;
        }
    }
    
}
