@extends('layout')

@section('body')
    <div class="p-3 mx-auto">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div class="cover-container">
                            <h1>Add Area</h1>
                            <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s.</p>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:add-area-form :categories="$categories" :owners="$owners" />
        </div>
    </div>
@endsection
