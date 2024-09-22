<?php

namespace App\Http\Controllers;

use App\Actions\HandelDataBeforeSaveAction;
use App\Filters\EndDateFilter;
use App\Filters\NameFilter;
use App\Filters\StartDateFilter;
use App\Filters\SubjectIdFilter;
use App\Filters\YearIdFilter;
use App\Http\Requests\GovernmentFormRequest;
use App\Http\Resources\GovernmentResource;
use App\Models\governments;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;


class GovernmentControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }
    public function index()
    {
        $data = governments::query()->orderBy('id', 'desc');
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                SubjectIdFilter::class,

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
        $output = governments::query()->updateOrCreate([
            'id' => $data['id']??null
        ],$data);
        return Messages::success(GovernmentResource::make($output),__('messages.saved_successfully'));
    }
    public function store(GovernmentFormRequest $request)
    {
        $data = $request->validated();
        $handeld_data = HandelDataBeforeSaveAction::handle($data);

      return $this->save($handeld_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = governments::query()->find($id);
        if($item){
            return $item;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GovernmentFormRequest $request, string $id)
    {
       $data = $request->validated();
       $handeld_data = HandelDataBeforeSaveAction::handle($data);
       $handeld_data['id'] = $id;
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
