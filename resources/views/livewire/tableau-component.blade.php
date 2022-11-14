<div>
    <main role="main" class="container">


        <!-- add button -->
        <button type="button" wire:click="false" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Nouvelle item
        </button>


        <!-- Modal add/edit -->
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
                                <form wire:submit.prevent>
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
                            <div class="mb-3">
                                <label class="form-label">Lowest</label>
                                <input wire:model="lowest" type="text" class="form-control">
                            </div>
                            @error('lowest')
                                <div class="alert alert-danger p-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="mb-3">
                                <label class="form-label">Bar code</label>
                                <input wire:model="barcode" type="text" class="form-control">
                            </div>
                            <label class="form-label">Catégorie</label>
                            @if ($inputCategory == false)
                                <div>
                                    <select wire:model="category" class="custom-select ">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button wire:click="showInput" type="button" class="btn btn-secondary">+</button>
                                    <button
                                        onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                        wire:click="removeCategory" type="button" class="btn btn-secondary">-</button>
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



                            <div class="d-flex justify-content-sm-end">
                                <button type="button" class="btn btn-secondary me-1"
                                    data-bs-dismiss="modal">Close</button>

                                @if ($fromEdit)
                                    <div>
                                        <button wire:click="remove" class="btn btn-danger"
                                            data-bs-dismiss="modal">supprimer</button>
                                        <button wire:click="edit" class="btn btn-primary">Save changes</button>
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



        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="numberModal" tabindex="-1" aria-labelledby="numberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="numberModalLabel">{{ $name }} - {{ $quantity }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th>{{ $item->item_id }}</th>
                            <th>{{ $item->name }}</th>
                            <th>
                                <button class="btn"
                                    wire:click="defineData('{{ $item->category->name }}', '{{ $item->name }}', '{{ $item->quantity }}', '{{ $item->barcode }}', '{{ $item->lowest }}')"
                                    data-bs-toggle="modal" data-bs-target="#numberModal">
                                    {{ $item->quantity }}
                                </button>
                            </th>

                            @if ($item->category)
                                <th>{{ $item->category->name }}</th>
                            @else
                                <th>-</th>
                            @endif
                            <th><button class="btn"
                                    wire:click="defineData('{{ $item->category->name }}', '{{ $item->name }}', '{{ $item->quantity }}', '{{ $item->barcode }}', '{{ $item->lowest }}')"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                            </th>
                            @if ($item->quantity < $item->lowest)
                                <th>⚠</th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </main>

</div>
