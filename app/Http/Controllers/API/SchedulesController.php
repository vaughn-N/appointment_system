<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Schedule;
use App\Models\Patient;
use App\Models\Doctor;

use App\Http\Resources\ScheduleResource;
use App\Http\Resources\SchedulesResource;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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

        $schedules = Schedule::where($where)->orderBy('id', $order)->get();

        return new SchedulesResource($schedules);
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

			$schedule = new Schedule($_input);
			$schedule->code = $schedule->generate_code();
		    $schedule->status = "Active";

            if(isset($_input['patiend_id'])){
                $patient_where = [
                    ['deprecated','=',0],
                    ['id','=', $_input['patient_id']]
                ];
                $patient = Patient::where($patient_where)->first();

              $schedule->patients()->associate($patient);

    
            }
            
            if(isset($_input['doctor_id'])){
                $doctor_where = [
                    ['deprecated','=',0],
                    ['id','=',$_input['doctor_id']]
                ];
                $doctor = Doctor::where($doctor_where)->first();

                $schedule->doctors()->associate($doctor);

            }

		    $schedule->save();

			DB::commit();

			$schedule_resource = new ScheduleResource($schedule);

			$data = [
				'status' => 'Success',
				'data' => [
					'id' => $schedule->id,
					'schedule' => $schedule_resource
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
        $schedule = Schedule::where($where)->first();
		
		if ($schedule) {
			return new ScheduleResource($schedule);
		} else {
			$errors = [
				'Schedule does not exist!'
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
			'name' => 'nullable', 
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
			$schedule = Schedule::where($where)->first();
			
			if ($schedule) {
				$schedule->fill($_input);

                if(isset($_input['patient_id'])){
                    $patient_where = [
                        ['deprecated','=',0],
                        ['id','=', $_input['patient_id']]
                    ];
                    $patient = Patient::where($patient_where)->first();
    
                    $schedule->patients()->associate($patient);
    
        
                }
                
                if(isset($_input['doctor_id'])){
                    $doctor_where = [
                        ['deprecated','=',0],
                        ['id','=',$_input['doctor_id']]
                    ];
                    $doctor = Doctor::where($doctor_where)->first();
    
                    $schedule->doctors()->associate($doctor);
    
                }

				$schedule->save();

				DB::commit();
				
				$schedule_resource = new ScheduleResource($schedule);

				$data = [
					'status' => 'Success',
					'data' => [
						'id' => $schedule->id,
						'schedule' => $schedule_resource
					]
				];
			} else {
				DB::rollback();
				
				$errors = [
					'Schedule does not exist!'
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
        $schedule = Schedule::where($where)->first();
		
		if ($schedule) {
			$schedule->deprecated = 1;
			$schedule->save();
			
			$schedule_resource = new ScheduleResource($schedule);

			$data = [
				'status' => 'Success',
				'data' => [
					'id' => $schedule->id,
					'schedule' => $schedule_resource
				]
			];			
		} else {
			$errors = [
				'Schedule does not exist!'
			];
			
			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
		}
		
		return response()->json($data);
    }
}
