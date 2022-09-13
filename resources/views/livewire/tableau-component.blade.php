<div>
    <button class="btn" wire:click="add">add</button>
    <main role="main" class="container">
        <h2 class="mt-5 text-center">Tableau</h2>
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
                            <th>

                                <button class="btn" wire:click='delete'>Supprimer</button>

                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>



</div>
