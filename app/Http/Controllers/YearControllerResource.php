<?php

namespace App\Http\Controllers;

use App\Actions\HandelDataBeforeSaveAction;
use App\Filters\EndDateFilter;
use App\Filters\GovernmentIdFilter;
use App\Filters\NameFilter;
use App\Filters\StartDateFilter;
use App\Filters\SubjectIdFilter;
use App\Http\Requests\CollageFormRequest;
use App\Http\Requests\GovernmentFormRequest;
use App\Http\Requests\YearFormRequest;
use App\Http\Resources\CollageResource;
use App\Http\Resources\GovernmentResource;
use App\Http\Resources\YearResource;
use App\Models\Collages_years;
use App\Models\years;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;


class YearControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }
    public function index()
    {
        $data =years::query()->orderBy('id', 'desc');
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
            ])->thenReturn()->paginate(10);
        return $result;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        DB::beginTransaction();

        $output = years::query()->updateOrCreate([
            'id' => $data['id'] ?? null
        ], $data);
        DB::commit();
        return Messages::success(YearResource::make($output), __('messages.saved_successfully'));
    }
    public function store(YearFormRequest $request)
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
        $item = years::query()->find($id);
        if($item){
            return $item;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(YearFormRequest $request, string $id)
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
