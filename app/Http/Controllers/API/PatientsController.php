<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patient;

use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientsResource;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$where = [
			['deprecated', '=', 0]
		];

		if ($request->input('status') AND $request->input('status') != null AND $request->input('status') != ''){
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

        $records = Patient::where($where)->orderBy('id', $order)->get();

        return new PatientsResource($records);
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
         //
        $rules = [
			// 'name' => 'unique:tags,name'
        ];

        $_input = $request->input();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
			$errors = $validator->errors()->toArray();

			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
        } else {
			DB::beginTransaction();

			$record = new Patient($_input);
			$record->code = $record->generate_code();
		    $record->status = "Active";
		
			// $record->Patient()->associate($listing);
			
		    $record->save();

			DB::commit();

			$record_resource = new PatientResource($record);

			$data = [
				'status' => 'Success',
				'data' => [
					'id' => $record->id,
					'patient' => $record_resource
				]
			];
        }
		
		return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $where = [
			['deprecated', '=', 0],
			['id', '=', $id]
		];
        $record = Patient::where($where)->first();
		
		if ($record) {
			return new PatientResource($record);
		} else {
			$errors = [
				'Patient does not exist!'
			];
			
			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];				
			
			return response()->json($data);
		}

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
        $rules = [
			'name' => 'required', 
        ];

        $_input = $request->input();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
			$errors = $validator->errors()->toArray();

			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
        } else {
            DB::beginTransaction();

			$where = [
				['deprecated', '=', 0],
				['id', '=', $id]
			];
			$record = Patient::where($where)->first();
			
			if ($record) {
				$record->fill($_input);
				$record->save();

				DB::commit();
				
				$record_resource = new PatientResource($record);

				$data = [
					'status' => 'Success',
					'data' => [
						'id' => $record->id,
						'Patient' => $record_resource
					]
				];
			} else {
				DB::rollback();
				
				$errors = [
					'Patient does not exist!'
				];				
				
				$data = [
					'status' => 'Fail',
					'errors' => $errors
				];
			}
        }
		
		return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $where = [
			['deprecated', '=', 0],
			['id', '=', $id]
		];
        $record = Patient::where($where)->first();
		
		if ($record) {
			$record->deprecated = 1;
			$record->save();
			
			$record_resource = new PatientResource($record);

			$data = [
				'status' => 'Success',
				'data' => [
					'id' => $record->id,
					'Patient' => $record_resource
				]
			];			
		} else {
			$errors = [
				'Patient does not exist!'
			];
			
			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
		}
		
		return response()->json($data);
    }
}