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
use App\Http\Requests\SubscribtionFormRequest;
use App\Http\Resources\SubjectResource;
use App\Models\governments;
use App\Models\subjects;
use App\Models\subscribtions;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Resources\SubscribtionResource;


class SubscribtionsControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }
    public function index()
    {
        $data = subscribtions::query()->orderBy('id', 'desc')
            //->with('user')->with('year')
            ->with(['user','subject']);
        $result = app(Pipeline::class)
            ->send($data)
            ->through([

                StartDateFilter::class,
                EndDateFilter::class,
                UserIdFilter::class,
                YearIdFilter::class,
            ])->thenReturn()->paginate(10);
        return $result;
//
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = subscribtions::query()->updateOrCreate([
            'id' => $data['id']??null
        ],$data);
        $output->load('user');
        $output->load('subject');
        return Messages::success(SubscribtionResource::make($output),__('messages.saved_successfully'));
    }
    public function store(SubscribtionFormRequest $request)
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
        $item = subscribtions::query()->find($id);
        if($item){
            return $item;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscribtionFormRequest $request, string $id)
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
