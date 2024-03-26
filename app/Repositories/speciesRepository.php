<?php

namespace App\Repositories;


use App\Models\Species;
use Illuminate\Http\Request;

class speciesRepository
{
    protected $species;
    public $request;

    public function __construct(Species $species, Request $request)
    {
        $this->species = $species;
        $this->request = $request;
    }

    // Get all species
    public function getAll()
    {
        $items = $this->request->items ?? 10;
        if($this->request['name'] == null && $this->request['status'] == null){
            $species = Species::orderBy('id', 'desc')
                ->orwhere('name', 'like', '%' . $this->request['name'] . '%')
                ->orwhere('status', 'like', '%' . $this->request['status'] . '%')
                ->paginate($items);
        }elseif ($this->request['name'] != null && $this->request['status'] == !null) {
            $species = Species::orderBy('id', 'desc')
                ->where('name', 'like', '%' . $this->request['name'] . '%')
                ->where('status', 'like', '%' . $this->request['status'] . '%')
                ->paginate($items);
        }elseif ($this->request['name'] != null && $this->request['status'] == null) {
            $species = Species::orderBy('id', 'desc')
                ->where('name', 'like', '%' . $this->request['name'] . '%')
                ->paginate($items);
        }else{
            $species = Species::orderBy('id', 'desc')
                ->where('status', 'like', '%' . $this->request['status'] . '%')
                ->paginate($items);
        }

        $trashedSpecies = Species::onlyTrashed()->count();

        $datas = [];
        $datas['status'] = 200;
        $datas['species'] = $species;
        $datas['trashed_species'] = $trashedSpecies;
        $datas['items_per_show'] = $items;

        return $datas;
    }

    // Get species by id
    public function getById($id)
    {
        $species = Species::where('id', $id)->get();

        $datas = [];
        $datas['success'] = true;
        $datas['status'] = 200;
        $datas['warehouse'] = $species;

        return $datas;
    }
    // Update species
    public function save()
    {
        $species = Species::create([
            'name' => $this->request['name'],
            'status' => $this->request['status'],
        ]);

        $datas = [];
        $datas['success'] = true;
        $datas['status'] = 200;
        $datas['message'] = 'Data created successfully!';
        $datas['data'] = $species->fresh();

        return $datas;
    }

    public function update($id)
    {
        $warehouse = Species::findOrFail($id);

        $warehouse->update([
            'name' => $this->request['name'],
            'status' => $this->request['status'],
        ]);

        $datas = [];
        $datas['success'] = true;
        $datas['status'] = 200;
        $datas['message'] = 'Data updated successfully!';
        $datas['data'] = $warehouse->fresh();

        return $datas;
    }

    public function softDeleteById($id)
    {
        $warehouse = Species::findOrFail($id);

        if ($warehouse) {
            $warehouse->delete();

            $datas = [];
            $datas['success'] = true;
            $datas['status'] = 200;
            $datas['message'] = 'Data deleted successfully!';

            return $datas;
        }
    }

}


