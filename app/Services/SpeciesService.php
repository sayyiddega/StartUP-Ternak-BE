<?php

namespace App\Services;

use App\Repositories\speciesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\API\Sepcies\SpeciesStoreRequest;
use App\Http\Requests\API\Sepcies\SpeciesUpdateRequest;

class SpeciesService
{
    protected $speciesRepository;
    public $request;
    protected $validator;

    public function __construct(Request $request, speciesRepository $speciesRepository, Validator $validator)
    {
        $this->speciesRepository = $speciesRepository;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function saveData()
    {
        $result = $this->speciesRepository->save();

        return $result;
    }

    public function getAll()
    {
        return $this->speciesRepository->getAll();
    }

    public function getById($id)
    {
        return $this->speciesRepository->getById($id);
    }

    public function updateSpecies($id)
    {
        DB::beginTransaction();

        try {
            $species = $this->speciesRepository->update($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            return response()->json([
                'error' => 'Unable to update warehouse data'
            ], 500);
        }

        DB::commit();

        return $species;
    }

    public function softDeleteById($id)
    {
        DB::beginTransaction();

        try {
            $species = $this->speciesRepository->softDeleteById($id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete data');
        }

        DB::commit();

        return $species;

    }

}
