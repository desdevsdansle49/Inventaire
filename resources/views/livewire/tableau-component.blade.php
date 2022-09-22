<div>
    <main role="main" class="container">
        

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        {{-- form --}}
                        <form wire:submit.prevent="addItem">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input wire:model="name" type="text" class="form-control">
                            </div>
                            @error('name')
                                <div class="alert alert-danger p-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input wire:model="quantity" type="text" class="form-control">
                            </div>
                            @error('quantity')
                                <div class="alert alert-danger p-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <h2 class="mt-5 text-center">Tableau</h2>




        <div class="d-flex flex-row-reverse mr-5 mb-3 justify-content-between">
            <div>
                per page
                <select wire:model.lazy="perPage" class="custom-select ">
                    @for ($i = 5; $i <= 25; $i += 5)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                Show
            </div>
            <div>
                <label for="query" class="visually-hidden">Search</label>
                <input type="search" wire:model="query" id="query" class="form-control w-auto"
                    placeholder="recherche">
            </div>
        </div>


        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Categorie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th>{{ $item->idItem }}</th>
                            <th>{{ $item->Name }}</th>
                            <th>{{ $item->Quantity }}</th>
                            <th></th>
                            <th>

                                <button class="btn" wire:click="remove('{{ $item->Name }}')">Supprimer</button>

                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </main>

</div>
