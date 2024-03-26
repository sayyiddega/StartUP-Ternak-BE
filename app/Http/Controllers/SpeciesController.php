<?php

namespace App\Http\Controllers;

use App\Models\Species;
use App\Requests\API\Species\SpeciesUpdateRequest;
use App\Services\SpeciesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Requests\API\Species\SpeciesStoreRequest;


class SpeciesController extends Controller
{
    public $request;
    protected $speciesService;
    protected $validator;

    public function __construct(Request $request, SpeciesService $speciesService, Validator $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->speciesService = $speciesService;

    }
    public function index(Request $request)
    {
       $request->validate([
            'name',
            'status',
        ]);

        try {
            $result = $this->speciesService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result);
    }

    public function store(SpeciesStoreRequest $input)
    {
        $input->validated();

        try {
            $result = $this->speciesService->saveData();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function show($id)
    {
        try {
            $result = $this->speciesService->getById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }


    public function destroy($id)
    {
        try {
            $result = $this->speciesService->softDeleteById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function update($id, SpeciesUpdateRequest $input)
    {
        $input->validated();

        try {
            $result = $this->speciesService->updateSpecies($id);

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
