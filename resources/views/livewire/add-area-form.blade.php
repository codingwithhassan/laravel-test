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
            <div class="form-group required mb-3">
                <label for="name" class="form-label">Name</label>
                <input placeholder="Enter Area Name" type="email" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.debounce.500ms="name">
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group required mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select @error('categoryId') is-invalid @enderror" id="category" wire:model="categoryId">
                    <option selected>Select Category</option>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}">{{ $category }}</option>
                    @endforeach
                </select>
                @error('categoryId')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group required mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="start_date" wire:model="startDate">
                @error('startDate')
                <span class="invalid-feedback">{{ $message }} </span>
                @enderror
            </div>
            <div class="form-group required mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="end_date" wire:model="endDate">
                @error('endDate')
                <span class="invalid-feedback"> {{ $message }} </span>
                @enderror
            </div>
            <div class="form-group required mb-3">
                <label for="owner" class="form-label">Owner</label>
                <select class="form-select @error('ownerId') is-invalid @enderror" id="owner" wire:model="ownerId">
                    <option selected>Select Owner</option>
                    @foreach($owners as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('ownerId')
                <span class="invalid-feedback">{{ $message }} </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">GeoJson File <span style="color: #b2b2b2">(GeoJson file with polygon)</span></label>
                <input type="file" onchange="handleFileSelect(event)" class="form-control @error('file') is-invalid @enderror" id="file" wire:model="file">
                @error('file')
                <span class="invalid-feedback"> {{ $message }} </span>
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
    function handleFileSelect(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                Livewire.emit('fileChosen', content);
            };
            reader.readAsText(file);
        }
    }
    function save(){
        console.log("window.drawnItems.toGeoJSON(): ",window.drawnItems.toGeoJSON())
        @this.save();
    }
</script>
