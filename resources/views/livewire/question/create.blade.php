<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
@endif
<!-- Main page content-->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">Crea un nuovo sondaggio</div>
            <div class="card-body">
                <div class="row">
                    <div id="the-basics" wire:ignore>
                        <input class="form-control typeahead" name="value1" wire:model="search" type="text" placeholder="States of USA">
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button wire:click.prevent="save()" class="btn btn-success">salva</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

