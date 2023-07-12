<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Livewire\Component;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

class AddAreaForm extends Component
{
    public $categories;
    public $owners;

    public $name;
    public $categoryId;
    public $startDate;
    public $endDate;
    public $ownerId;

    public $coordinates;

    protected $rules = [
        'name' => 'required',
        'categoryId' => 'required',
        'startDate' => 'required',
        'endDate' => 'required',
        'ownerId' => 'required',
        'coordinates' => 'required',
    ];

    protected $listeners = [
        'polygonAdded' => 'addPolygon',
        'polygonUpdated' => 'updatePolygon',
    ];

    function addPolygon($polygonLines){
        $this->coordinates = $polygonLines;
    }

    function updatePolygon($polygonLines){
        $this->coordinates = $polygonLines;
    }

    public function dehydrate(){
        $this->dispatchBrowserEvent('contentAreaFormChanged', $this->coordinates);
    }

    public function clearFields(){
        $this->name = null;
        $this->categoryId = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->ownerId = null;
        $this->coordinates = null;
    }

    public function save(){
        $this->validate();

        $lines = [];

        foreach ($this->coordinates as $index => $line){
            $coordinates = [];
            foreach ($line as $coordinate){
                $coordinates[] = new Point($coordinate[0], $coordinate[1]);
            }
            $lines[$index] = new LineString($coordinates);
        }

        Area::create([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'coordinates' => new Polygon($lines),
            'category_id' => $this->categoryId,
            'owner_id' => $this->ownerId,
        ]);

        session()->flash('message', $this->name. ' area created successfully.');

        $this->clearFields();
    }
    public function render()
    {
        return view('livewire.add-area-form');
    }
}
