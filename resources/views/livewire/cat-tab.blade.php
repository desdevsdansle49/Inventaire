<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <button type="button" class="btn mb-3 bgBtn" data-bs-toggle="modal" data-bs-target="#exampleModal"
            wire:click=false>
            Nouvelle catégorie
        </button>

        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($fromEdit)
                            <h5 class="modal-title" id="exampleModalLabel">{{ $name2 }}</h5>
                        @else
                            <h5 class="modal-title" id="exampleModalLabel">Nouvelle catégorie</h5>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- form --}}
                        <form>

                            <input wire:model="name" type="text" class="form-control">
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
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>
                        </form>
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
                            <th><button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    wire:click="defineData('{{ $item }}')">⚙</button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
