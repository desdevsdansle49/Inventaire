<div>
    <main role="main" class="container">


        <!-- Button trigger modal -->
        <button type="button" wire:click="false" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
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
                        @if ($fromEdit)
                            <form wire:submit.prevent="remove">
                            @else
                                <form wire:submit.prevent="addItem">
                        @endif
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
                        <label class="form-label">Catégorie</label>
                        @if ($inputCategory == false)
                            <div>
                                <select wire:model="category" class="custom-select ">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="showInput" type="button" class="btn btn-secondary">+</button>
                                <button wire:click="removeCategory" type="button" class="btn btn-secondary">-</button>
                            </div>
                        @else
                            <div>
                                <div class="mb-3  border rounded p-3">
                                    <label class="form-label">Catégorie</label>
                                    <input wire:model="category" type="text" class="form-control mb-2">
                                    <button wire:click="showInput" type="button"
                                        class="btn btn-secondary">Annuler</button>
                                    <button wire:click="addCategory" type="button"
                                        class="btn btn-primary">Ajouter</button>

                                </div>
                            </div>
                        @endif

                        <div align="right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @if ($fromEdit)
                                <button wire:click="remove" class="btn btn-danger"
                                    data-bs-dismiss="modal">supprimer</button>
                                <button type="submite" class="btn btn-primary">Save changes</button>
                            @else
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            @endif
                        </div>

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
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th>{{ $item->item_id }}</th>
                            <th>{{ $item->name }}</th>
                            <th>{{ $item->quantity }}</th>
                            @if ($item->category)
                                <th>{{ $item->category->name }}</th>
                            @else
                                <th>-</th>
                            @endif
                            <th><button class="btn"
                                    wire:click="defineData('{{ $item->category->name }}', '{{ $item->name }}', '{{ $item->quantity }}')"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </main>

</div>
