<?php

namespace App\Http\Controllers;

use App\Sample;
use Illuminate\Http\Request;
use App\Exports\SampleExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

class SampleController
{
    public function index()
    {
        $samplesPerPlate = config('plate.rows') * config('plate.columns');

        $paginator = Sample::orderBy('position')->simplePaginate($samplesPerPlate);
        $samples = $paginator->getCollection();
        for($i = $samples->count(); $i < $samplesPerPlate; $i++) {
            $emptySample = new Sample;

            $emptySample->id = '';
            $emptySample->position = (optional($samples->last())->position ?? 0) + 1;
            $emptySample->created_at = now();
            $emptySample->updated_at = now();
            $samples[] = $emptySample;
        }
        $paginator->setCollection($samples);
        return array_merge([
            'rows' => (int) config('plate.rows'),
            'columns' => (int) config('plate.columns')
        ], $paginator->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        if($sample = Sample::find($request->id)) {
            return $sample;
        }

        $sample = new Sample;
        $sample->id = $request->get('id');
        $sample->position = Sample::nextPosition();
        $sample->save();
        return $sample;
    }

    public function destroy(Sample $sample)
    {
        if(Sample::nextPosition() - 1 == $sample->position) {
            $sample->delete();
        }
        return response(200);
    }

    public function destroyAll()
    {
        DB::table('samples')->delete();
        return response(200);
    }

    public function download()
    {
        return Excel::download(new SampleExport, 'samples.xlsx');
    }
}
