<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Validator; 

class PersonController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'email' => 'required|email',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was Invalid', 'data'=>$validator->errors()],422);  
            }

            $person = new Person();
            $person->name = $request->name;
            $person->email = $request->email;
            $person->save();

            return response()->json(['success'=>true, 'person_id'=>intval($person->id), 'message'=>'Successfully a person has been added']);

        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return response()->json(['success'=>true, 'data'=>$person]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'email' => 'required|email',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was Invalid', 'data'=>$validator->errors()],422);  
            }

            $person->name = $request->name;
            $person->email = $request->email;
            $person->update();

            return response()->json(['success'=>true, 'person_id'=>intval($person->id), 'message'=>'Successfully the person has been updated']);

        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        try
        {
            $person->delete();
            return response()->json(['success'=>true, 'message'=>'Successfully the person has been deleted']);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
        }
    }
}
