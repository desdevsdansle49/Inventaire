<div class="bg-white rounded p-5 m-4">

    <main role="main" class="container">

        <div wire:ignore.self class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Nouvelle entitée</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <select wire:model="selectEntity" name="type" class="mb-3">
                            <option value="department" selected>Department</option>
                            <option value="unit">Unit</option>
                            <option value="employee">Employee</option>
                        </select>

                        <input wire:model="newInput" type="text" class="form-control">
                        @error('newInput')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        @if ($selectEntity == 'unit')
                            @isset($allDepartment)
                                <select wire:model="selectNewLink" class="mt-3">
                                    @foreach ($allDepartment as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endisset
                        @endif
                        @if ($selectEntity == 'employee')
                            @isset($allUnit)
                                <select wire:model="selectNewLink" class="mt-3">
                                    @foreach ($allUnit as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endisset
                        @endif
                        <div class=" mt-3 d-flex justify-content-sm-end">
                            <button wire:click="wichEntityToAdd" class=" ms-2 btn btn-primary">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn mb-3 bgBtn" data-bs-toggle="modal" data-bs-target="#newModal">
                Nouvelle entitée
            </button>

            <div class="d-flex flex-column">
                <label>
                    <input type="radio" value="add" wire:change="$emitUp('toggleTableEvent')">
                    Catégorie
                </label>
                <label>

                    <input type="radio" value="department" wire:change="$emitUp('toggleTableEvent')" checked>
                    Département
                </label>
            </div>

        </div>



        {{-- Modals --}}
        <div wire:ignore.self class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($departmentName)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $departmentName2 }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input wire:model="departmentName" type="text" class="form-control">
                        @error('departmentName')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class=" mt-3 d-flex justify-content-sm-end">
                            @if ($fromEdit)
                                <div></div>
                                <button
                                    onclick="confirm('Etes vous sur de supprimer ce département ?') || event.stopImmediatePropagation()"
                                    type="button" data-bs-dismiss="modal" wire:click="removeDepartment"
                                    class="btn btn-danger">Supprimer</button>
                                <button wire:click="editDepartment" class="ms-2 btn btn-primary">Sauvegarder</button>
                            @else
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($unitName)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $unitName2 }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input wire:model="unitName" type="text" class="form-control">
                        @error('unitName')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        @isset($linkedDepartment->id)
                            <select wire:model="selectForUnit" class="mt-3">
                                @foreach ($allDepartment as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endisset
                        <div class=" mt-3 d-flex justify-content-sm-end">
                            <button
                                onclick="confirm('Etes vous sur de supprimer cette unité ?') || event.stopImmediatePropagation()"
                                wire:click="removeUnit" type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Supprimer</button>
                            <button wire:click="editUnit" class=" ms-2 btn btn-primary">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($employeeName)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $employeeName }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @isset($linkedUnit->id)
                            <input wire:model="employeeName" type="text" class="form-control">
                            @error('employeeName')
                                <div class="alert alert-danger mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <select wire:model="selectForEmployee" id="itemSelect" class="mt-3">
                                @foreach ($allUnit as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endisset
                        <div class=" mt-3 d-flex justify-content-sm-end">
                            <button
                                onclick="confirm('Etes vous sur de supprimer cette unité ?') || event.stopImmediatePropagation()"
                                wire:click="removeEmployee" type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Supprimer</button>
                            <button wire:click="editEmployee" class="btn btn-primary">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- search --}}
        <div class="d-flex align-items-center">
            <label for="query" class="visually-hidden">Search</label>
            <input type="search" wire:model="query" id="query" class="form-control w-auto mb-3"
                placeholder="recherche">
        </div>


        {{-- Tableaux --}}
        <div class="d-flex justify-content-between">
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
                        @foreach ($resultDepartment as $department)
                            @if ($department->name != '-')
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $department->name }}</th>
                                    <th><button class="btn" data-bs-toggle="modal"
                                            data-bs-target="#departmentModal"
                                            wire:click="getDataDepartment('{{ $department }}')">⚙</button>
                                    </th>
                                </tr>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <div class="vr mx-5"></div>
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
                        @foreach ($resultUnit as $unit)
                            @if ($unit->name != '-')
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $unit->name }}</th>
                                    <th><button class="btn" data-bs-toggle="modal" data-bs-target="#unitModal"
                                            wire:click="getDataUnit('{{ $unit }}')">⚙</button>
                                    </th>
                                </tr>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <div class="vr mx-5"></div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="th1"></th>
                            <th class="th2">Nom</th>
                            <th class="th7">Editer</th>
                            {{-- <th class="th7"></th> --}}

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultEmployee as $employee)
                            @if ($employee->name != '-')
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $employee->name }}</th>
                                    <th><button class="btn" data-bs-toggle="modal" data-bs-target="#employeeModal"
                                            wire:click="getDataEmployee('{{ $employee }}')">⚙</button>

                                    </th>
                                    {{-- <th><input class="ms-3 me-1 mb-3" type="checkbox" id="selectDepartment"
                                        name="selectDepartment"></th>
                                 --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
