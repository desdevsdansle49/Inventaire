<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <button type="button" class="btn mb-3 bgBtn" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Nouvelle item
        </button>

        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($fromEdit)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $name }}</h5>
                        @else
                            <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        {{-- form --}}
                        <div>
                            @if ($fromEdit)
                                <form wire:submit.prevent wire:keydown.enter='edit'
                                    onkeydown="return event.key != 'Enter';">
                                @else
                                    <form wire:submit.prevent="addItem">
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input wire:model="name" type="text" class="form-control">
                            </div>
                            @error('name')
                                <div class="alert alert-danger p-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="d-flex justify-content-between">
                                <div class="mb-3">
                                    <label class="form-label">Quantité</label>
                                    <input wire:model="quantity" type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Minimum</label>
                                    <input wire:model="lowest" type="text" class="form-control">
                                </div>


                            </div>
                            <div class="d-flex justify-content-between">
                                @error('quantity')
                                    <div class="alert alert-danger p-2" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('lowest')
                                    <div class="alert alert-danger p-2" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="mb-3">
                                    <label class="form-label">CodeBare</label>
                                    <input wire:model="barcode" type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Emplacement</label>
                                    <input wire:model="emplacement" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                @error('barcode')
                                    <div class="alert alert-danger p-2" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('lowest')
                                    <div class="alert alert-danger p-2" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fournisseur</label>
                                <input wire:model="fournisseur" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Note</label>
                                <textarea rows="3" wire:model="note" class="form-control"></textarea>
                            </div>
                            <label class="form-label">Catégorie</label>




                            <div class="d-flex justify-content-sm-end">
                                @if ($fromEdit)
                                    <div>
                                        <button onclick="confirm('Etes vous sur ?') || event.stopImmediatePropagation()"
                                            wire:click="remove" class="btn btn-danger"
                                            data-bs-dismiss="modal">Supprimer</button>
                                        <button wire:click="edit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <label for="query" class="visually-hidden">Search</label>
            <input type="search" wire:model="query" id="query" class="form-control w-auto mb-3"
                placeholder="recherche">
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th class="th1"></th>
                        <th class="th2">Nom</th>
                        <th class="th7">Editer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th></th>
                            <th class="fw-normal">{{ $item->name }}</th>
                            <th><button class="btn" wire:click="">⚙</button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
