<div class="bg-white rounded p-5 m-4 shadow-sm">
    <main role="main" class="container">



        @if ($fromCreate)

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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                <div class="mb-2">
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
                                        <div class="pt-2">
                                            @error('quantity')
                                                <div class="alert alert-danger p-2" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Minimum</label>
                                        <input wire:model="lowest" type="text" class="form-control">
                                        <div class="pt-2">
                                            @error('lowest')
                                                <div class="alert alert-danger p-2" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
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
                                @if ($inputCategory == false)
                                    <div>
                                        <select wire:model="category" class="custom-select ">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <button wire:click="showInput('category')" type="button"
                                            class="btn btn-secondary">+</button>
                                        <button
                                            onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                            wire:click="removeCategory" type="button"
                                            class="btn btn-secondary">-</button>
                                    </div>
                                @else
                                    <div>
                                        <div class="mb-3  border rounded p-3">
                                            <label class="form-label">Catégorie</label>
                                            <input wire:model="category" type="text" class="form-control mb-2">
                                            <button wire:click="showInput('category')" type="button"
                                                class="btn btn-secondary">Annuler</button>
                                            <button wire:click="addCategory" type="button"
                                                class="btn btn-primary">Ajouter</button>

                                        </div>
                                    </div>
                                @endif



                                <div class="d-flex justify-content-sm-end">
                                    @if ($fromEdit)
                                        <div>
                                            <button
                                                onclick="confirm('Etes vous sur ?') || event.stopImmediatePropagation()"
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

        @endif



        <!-- Modal Quantity -->
        <div wire:ignore.self class="modal fade" id="numberModal" tabindex="-1" aria-labelledby="numberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="numberModalLabel"> {{ $quantity }} - {{ $name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div height-10>
                                <button data-bs-dismiss="modal" wire:click="addQuantity('-')" type="button"
                                    class="btn btn-secondary"> -
                                </button>
                            </div>
                            <input wire:model="addQuantity" style="width: 150px;" type="text"
                                class="m-2 form-control" />
                            <div class="height-10">
                                <button data-bs-dismiss="modal" wire:click="addQuantity('+')" type="button"
                                    class="btn btn-secondary">+</button>
                            </div>
                        </div>
                        <label class="form-label">Département</label>
                        @if ($inputDepartment == false)
                            <div>
                                <select wire:model="department" class="custom-select ">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="showInput('department')" type="button"
                                    class="btn btn-secondary">+</button>
                                <button
                                    onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                    wire:click="removeDUE('department')" type="button"
                                    class="btn btn-secondary">-</button>
                            </div>
                        @else
                            <div>
                                <div class="mb-3  border rounded p-3">
                                    <label class="form-label">Département</label>
                                    <input wire:model="department" type="text" class="form-control mb-2">
                                    <button wire:click="showInput('department')" type="button"
                                        class="btn btn-secondary">Annuler</button>
                                    <button wire:click="addDUE('department')" type="button"
                                        class="btn btn-primary">Ajouter</button>

                                </div>
                            </div>
                        @endif
                        @if ($inputUnit == false)
                            <div>
                                <select wire:model="unit" class="custom-select ">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="showInput('unit')" type="button"
                                    class="btn btn-secondary">+</button>
                                <button
                                    onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                    wire:click="removeDUE('unit')" type="button"
                                    class="btn btn-secondary">-</button>
                            </div>
                        @else
                            <div>
                                <div class="mb-3  border rounded p-3">
                                    <label class="form-label">Unité</label>
                                    <input wire:model="unit" type="text" class="form-control mb-2">
                                    <button wire:click="showInput('unit')" type="button"
                                        class="btn btn-secondary">Annuler</button>
                                    <button wire:click="addDUE('unit')" type="button"
                                        class="btn btn-primary">Ajouter</button>

                                </div>
                            </div>
                        @endif
                        @if ($inputEmployee == false)
                            <div>
                                <select wire:model="employee" class="custom-select ">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="showInput('employee')" type="button"
                                    class="btn btn-secondary">+</button>
                                <button
                                    onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                    wire:click="removeDUE('employee')" type="button"
                                    class="btn btn-secondary">-</button>
                            </div>
                        @else
                            <div>
                                <div class="mb-3 border rounded p-3">
                                    <label class="form-label">Employé</label>
                                    <input wire:model="employee" type="text" class="form-control mb-2">
                                    <button wire:click="showInput('employee')" type="button"
                                        class="btn btn-secondary">Annuler</button>
                                    <button wire:click="addDUE('employee')" type="button"
                                        class="btn btn-primary">Ajouter</button>

                                </div>
                            </div>
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Note -->
        <div wire:ignore.self class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noteModalLabel">{{ $name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $note }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-2 text-center">Inventaire</h2>

        @if ($fromCreate)
            <!-- add button -->
            <button type="button" wire:click="false" class="btn mb-3 bgBtn" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Nouvelle item
            </button>
        @endif


        <div class="d-flex flex-row-reverse mr-5 mb-3 justify-content-between">
            <div>
                Elements par page :
                <select wire:model.lazy="perPage" class="custom-select ">
                    @for ($i = 5; $i <= 25; $i += 5)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="d-flex align-items-center">
                <label for="query" class="visually-hidden">Search</label>
                <input type="search" wire:model="query" id="query" class="form-control w-auto "
                    placeholder="recherche">
                <input class="ms-3 me-1" wire:model='alerte'type="checkbox" id="alerte" name="alerte">
                <label for="alerte">Alerte</label>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table">
                <thead class="table-active">
                    <tr>
                        <th class="th1"></th>
                        <th class="th2">Nom</th>
                        <th class="th3">Quantité</th>
                        <th class="th4">Categorie</th>
                        <th class="th5">Fournisseur</th>
                        <th class="th6">Note</th>
                        <th class="th7">Editer</th>
                        <th class="th8"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        @if ($item->category)
                        @endif
                        <tr>
                            <th></th>
                            <th class="fw-normal">{{ $item->name }}</th>
                            <th>
                                <button class="btn" wire:click="defineData('{{ $item }}')"
                                    data-bs-toggle="modal" data-bs-target="#numberModal">
                                    {{ $item->quantity }}
                                </button>
                            </th>

                            @if ($item->category)
                                <th class="fw-normal">{{ $item->category->name }}</th>
                            @else
                                <th>-</th>
                            @endif

                            <th class="fw-normal">{{ $item->fournisseur }}</th>
                            <th>
                                <button class="btn" wire:click="defineData('{{ $item }}')"
                                    data-bs-toggle="modal" data-bs-target="#noteModal">...</button>
                            </th>
                            @if ($fromCreate)
                                <th><button class="btn" wire:click="defineData('{{ $item }}')"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">⚙</button>
                                </th>
                            @endif
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
