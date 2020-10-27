<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
@endif
<!-- Main page content-->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">Carica lista giocatori da fantagazzetta</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="mb-1">Stagione</label>
                            @error('season') <span class="error">{{ $message }}</span> @enderror
                            <input class="form-control" type="text" placeholder="Inserisci la stagione"
                                   wire:model="season">

                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="mb-1">Carica file</label>
                            @error('file') <span class="error">{{ $message }}</span> @enderror
                            <input type="file" wire:model="file">


                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button wire:click.prevent="save()" class="btn btn-success">Carica file</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
