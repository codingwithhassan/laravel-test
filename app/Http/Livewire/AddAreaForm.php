<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Data\Geometries\LineString;
use Clickbar\Magellan\Data\Geometries\Polygon;
use Clickbar\Magellan\Data\Geometries\MultiPolygon;

class AddAreaForm extends Component
{
    use WithFileUploads;

    public $categories;
    public $owners;
    public $name;
    public $categoryId;
    public $startDate;
    public $endDate;
    public $ownerId;
    public $coordinates;
    public $file;

    function mount()
    {
        $date = now()->toDateString();
        $this->startDate = $date;
        $this->endDate = $date;
    }

    protected array $rules = [
        'name' => 'required',
        'categoryId' => 'required',
        'startDate' => 'required',
        'endDate' => 'required',
        'ownerId' => 'required',
        'coordinates' => 'required',
        'file' => 'nullable|file|mimes:json,geojson',
    ];

    protected $listeners = [
        'polygonAdded' => 'addPolygon',
        'polygonUpdated' => 'updatePolygon',
        'fileChosen' => 'uploadFileAndDrawPolygon'
    ];

    function addPolygon($polygonGeoJson): void
    {
        if ($this->coordinates) {
            foreach ($polygonGeoJson['geometry']['coordinates'] as $line) {
                $this->coordinates[] = $line;
            }
        } else {
            $this->coordinates = $polygonGeoJson['geometry']['coordinates'];
        }
    }

    function updatePolygon($polygonLines): void
    {
        $this->coordinates = $polygonLines;
    }

    function uploadFileAndDrawPolygon($geoJson)
    {
        $geoJson = json_decode($geoJson, true);
        foreach ($geoJson['features'] as $feature) {
            if ($feature['geometry']['type'] == 'Polygon') {
                if ($this->coordinates) {
                    foreach ($feature['geometry']['coordinates'] as $line) {
                        $this->coordinates[] = $line;
                    }
                } else {
                    $this->coordinates = $feature['geometry']['coordinates'];
                }
            }
        }
    }

    public function dehydrate(): void
    {
        $this->dispatchBrowserEvent('contentAreaFormChanged', $this->coordinates);
    }

    public function clearFields(): void
    {
        $this->name = null;
        $this->categoryId = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->ownerId = null;
        $this->coordinates = null;
        $this->file = null;
    }

    public function save()
    {
        $this->validate();

        $polygons = [];
        foreach ($this->coordinates as $lineIndex => $line) {
            $points = [];
            foreach ($line as $point) {
                $points[] = Point::make($point[0], $point[1]);
            }
            $polygons[] = Polygon::make([LineString::make($points)]);
        }

        $path = null;
        if ($this->file) {
            $path = $this->file->storeAs('geojson', Str::random() . "." . $this->file->getClientOriginalExtension());

//            $content = file_get_contents(storage_path('app/' . $path));
        }

        Area::create([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'coordinates' => MultiPolygon::make($polygons),
            'category_id' => $this->categoryId,
            'owner_id' => $this->ownerId,
            'path' => $path,
        ]);

        session()->flash('message', $this->name . ' area created successfully.');

        $this->clearFields();
    }

    public function render(): View
    {
        return view('livewire.add-area-form');
    }
}
