<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <button type="button" class="btn mb-3 bgBtn" data-bs-toggle="modal" data-bs-target="#exampleModal"
            wire:click=false>
            Nouvelle catégorie
        </button>

        <div wire:ignore.self class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($linkedDepartment[0]->name)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $linkedDepartment[0]->name }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        {{-- <form wire:submit.prevent>

                            <input wire:model="name" type="text" class="form-control">
                            @error('name')
                                <div class="alert alert-danger mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class=" mt-3 d-flex justify-content-sm-end">
                                @if ($fromEdit)
                                    <div>
                                        <button
                                            onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                            wire:click="removeCategory" type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Supprimer</button>
                                        <button wire:click="edit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        wire:click="addCategory">Ajouter</button>
                                @endif
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($linkedUnit)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $linkedUnit }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        {{-- <form wire:submit.prevent>

                            <input wire:model="name" type="text" class="form-control">
                            @error('name')
                                <div class="alert alert-danger mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class=" mt-3 d-flex justify-content-sm-end">
                                @if ($fromEdit)
                                    <div>
                                        <button
                                            onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                            wire:click="removeCategory" type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Supprimer</button>
                                        <button wire:click="edit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        wire:click="addCategory">Ajouter</button>
                                @endif
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @isset($linkedDepartment[0]->name)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $linkedDepartment[0]->name }}</h5>
                        @endisset
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        {{-- <form wire:submit.prevent>

                            <input wire:model="name" type="text" class="form-control">
                            @error('name')
                                <div class="alert alert-danger mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class=" mt-3 d-flex justify-content-sm-end">
                                @if ($fromEdit)
                                    <div>
                                        <button
                                            onclick="confirm('Are you sure you want to remove the user from this group?') || event.stopImmediatePropagation()"
                                            wire:click="removeCategory" type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Supprimer</button>
                                        <button wire:click="edit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        wire:click="addCategory">Ajouter</button>
                                @endif
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <label for="query" class="visually-hidden">Search</label>
            <input type="search" wire:model="query" id="query" class="form-control w-auto mb-3"
                placeholder="recherche">
        </div>
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
                            <tr>
                                <th></th>
                                <th class="fw-normal">{{ $department->name }}</th>
                                <th><button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        wire:click="getDataDepartment('{{ $department->name }}')">⚙</button>
                                </th>
                            </tr>
                            </tr>
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
                            <tr>
                                <th></th>
                                <th class="fw-normal">{{ $unit->name }}</th>
                                <th><button class="btn" data-bs-toggle="modal" data-bs-target="#unitModal"
                                        wire:click="getDataUnit('{{ $unit }}')">⚙</button>
                                </th>
                            </tr>
                            </tr>
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
                            <tr>
                                <th></th>
                                <th class="fw-normal">{{ $employee->name }}</th>
                                <th><button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        wire:click="defineData('{{ $employee }} , ')">⚙</button>
                                </th>
                                {{-- <th><input class="ms-3 me-1 mb-3" type="checkbox" id="selectDepartment"
                                        name="selectDepartment"></th>
                                 --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
{{-- foreach ($department->units as $unit) {
            echo "Unité: " . $unit->name . "\n";
            foreach ($unit->employees as $employee) {
                echo "Employé: " . $employee->name . "\n";
            }
        } --}}
