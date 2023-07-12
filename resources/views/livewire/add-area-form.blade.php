<div class="row">
    <div class="col-12">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="col-12 py-5">
        <div id="map" style="width: 100%; height: 400px;"></div>
        @error('coordinates')
        <span class="text-danger">{{ $message }} </span>
        @enderror
    </div>
    <div class="col-12">
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="email" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.debounce.500ms="name">
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Select Category</label>
                <select class="form-select @error('categoryId') is-invalid @enderror" id="category" wire:model="categoryId">
                    <option selected>Open this select menu</option>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}">{{ $category }}</option>
                    @endforeach
                </select>
                @error('categoryId')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="start_date" wire:model="startDate">
                @error('startDate')
                <span class="invalid-feedback">{{ $message }} </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="end_date" wire:model="endDate">
                @error('endDate')
                <span class="invalid-feedback"> {{ $message }} </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="owner" class="form-label">Owner</label>
                <select class="form-select @error('ownerId') is-invalid @enderror" id="owner" wire:model="ownerId">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                @error('ownerId')
                <span class="invalid-feedback">{{ $message }} </span>
                @enderror
            </div>
        </form>
    </div>
    <div class="col-12">
        <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
    </div>
</div>
@vite('resources/js/leaflet.js')
<script>
    function save(){
        console.log("window.drawnItems.toGeoJSON(): ",window.drawnItems.toGeoJSON())
        @this.save();
    }
</script>
