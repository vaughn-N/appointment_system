<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patient;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = [
			['deprecated', '=', 0]
		];

		if ($request->input('status') AND $request->input('status') != null AND $request->input('status') != '') {
			$where[] = [
		 		'status', '=', $request->input('status')
		 	];
		}

		$order = 'asc';
		if ($request->input('order') AND $request->input('order') != null AND $request->input('order') != '') {
		 	if ($request->input('order') == 'asc' OR $request->input('order') == 'desc') {
		 		$order = $request->input('order');
		 	}
		}

        $records = Listing::where($where)->orderBy('id', $order)->get();

        $data = [];
        if ($records){
            
            $data = [
                'id' => $record->id,

                'status' => $record->status,
                'type' => $record->type,

                'code' => $record->code,

                'first_name' => $record->first_name,
                'last_name' => $record->last_name,
                'gender' => $record->gender,
                'status' => $record->status,
                'chief_complaint' => $record->chief_complaint,
                'contact_no' => $record->contact_no,
            ];
        }

        return $data;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
