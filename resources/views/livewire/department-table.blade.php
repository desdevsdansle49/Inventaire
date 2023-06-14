<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">
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
                    {{-- @foreach ($items as $item)
                        <tr>
                            <th></th>
                            <th class="fw-normal">{{ $item->name }}</th>
                            <th><button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    wire:click="defineData('{{ $item }}')">⚙</button>
                            </th>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </main>
</div>
