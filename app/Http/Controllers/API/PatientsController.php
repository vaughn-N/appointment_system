<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

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

        if ($request->input('status') and $request->input('status') != null and $request->input('status') != '') {
            $where[] = [
                'status', '=', $request->input('status')
            ];
        }

        $order = 'asc';
        if ($request->input('order') and $request->input('order') != null and $request->input('order') != '') {
            if ($request->input('order') == 'asc' or $request->input('order') == 'desc') {
                $order = $request->input('order');
            }
        }

        $patients = Patient::where($where)->orderBy('id', $order)->get();

        return new PatientsResource($patients);
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
        $rules = [];

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

            $patient = new Patient($_input);
            $patient->code = $patient->generate_code();
            $patient->status = "Active";

            $patient->save();

            DB::commit();

            $patient_resource = new PatientsResource($patient);

            $data = [
                'status' => 'Success',
                'data' => [
                    'id' => $patient->id,
                    'patient' => $patient_resource
                ]
            ];

            return response()->json($data);
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
        $where = [
            ['deprecated', '=', 0],
            ['id', '=', $id]
        ];

        $patient = Patient::where($where)->first();

        if ($patient) {
            return new PatientResource($patient);
        } else {
            $errors = [
                'Patient Does not Exist'
            ];

            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];
        }

        return response()->json($data);
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
        $rules = [];

        $_input = $request->input();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];

        }
        else {
            DB::beginTransaction();

            $where = [
                ['deprecated','=',0],
                ['id','=',$id]
            ];

            $patient = Patient::where($where)->first();

            if ($patient) {
                $patient->fill($_input);
                $patient->save();

                DB::commit();

                $patient_resource = new PatientResource($patient);


                $data = [
                    'status' => 'Success',
                    'data'=> [
                        'id' => $patient->id,
                        'patient' => $patient_resource,
                    ]
                ];
            } 
            else {
                DB::rollback();

                $errors = [
                    'Patient Does not exist'
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

        $patient = ContactUs::where($where)->first();

        if ($patient) {
            $patient->deprecated = 1;
            $patient->save();

            $patient_resource= new ContactFormResource($patient);

            $data = [
                'status' => 'Success',
                'data' => [
                    'id' => $patient->id,
                    'contact form' => $patient_resource
                ]
            ];
        } else {
            $errors = [
                'Contact Form does not exist!'
            ];
            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];
        }
        
        return response()->json($data);
    }
}
