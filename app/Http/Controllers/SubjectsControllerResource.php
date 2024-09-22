<?php

namespace App\Http\Controllers;

use App\Actions\HandelDataBeforeSaveAction;
use App\Filters\EndDateFilter;
use App\Filters\NameFilter;
use App\Filters\StartDateFilter;
use App\Filters\SubjectIdFilter;
use App\Filters\UserIdFilter;
use App\Filters\YearIdFilter;
use App\Http\Requests\SubjectFormRequest;
use App\Http\Resources\SubjectResource;
use App\Models\governments;
use App\Models\subjects;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;


class SubjectsControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }
    public function index()
    {
        $data = subjects::query()->orderBy('id', 'desc')
            //->with('user')->with('year')
            ->with(['user','year'=>function ($e) {
                $e->with(['year','collage']);
            }]);
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                UserIdFilter::class,
                YearIdFilter::class,
            ])->thenReturn()->paginate(10);
        return $result;
//        $data =governments::query();
//        if(request()->filled('name')){
//            $data->where('name','like','%'.request()->name.'%');
//        }
//        if(request()->filled('start_date')){
//            $data->where('created_at,'>=' ,request()->start_date');
//        }
//        if(request()->filled('endt_date')){
//            $data->where('created_at,'<=' ,request()->end_date');
//        }
//        return $data->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = subjects::query()->updateOrCreate([
            'id' => $data['id']??null
        ],$data);
        $output->load('user');
        $output->load('year');
        return Messages::success(SubjectResource::make($output),__('messages.saved_successfully'));
    }
    public function store(SubjectFormRequest $request)
    {
        $data = $request->validated();
        $handeld_data = HandelDataBeforeSaveAction::handle($data);
        $handeld_data['year_id'] = $data['yearid'];
        unset($handeld_data['yearid']);

        return $this->save($handeld_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = subjects::query()->find($id);
        if($item){
            return $item;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectFormRequest $request, string $id)
    {
        $data = $request->validated();
        $handeld_data = HandelDataBeforeSaveAction::handle($data);
        $handeld_data['id'] = $id;
        $handeld_data['year_id'] = $data['yearid'];
        unset($handeld_data['yearid']);
        return $this->save($handeld_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
