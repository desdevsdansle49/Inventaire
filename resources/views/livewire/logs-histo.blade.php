<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <h2 class="mt-2 mb-5 text-center">Historique</h2>

        <input class="ms-3 me-1 mb-3" wire:model='altTable'type="checkbox" id="alerte" name="alerte">
        <label for="alerte">Historique des modifications</label>
        <div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="th1"></th>
                            <th class="th2">Nom</th>
                            <th class="th3">Action</th>
                            <th class="th4">Temps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($this->altTable == true)
                            @foreach ($LogHisto as $item)
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $item->name }}</th>
                                    <th class="fw-normal">{{ $item->action }}</th>
                                    <th class="fw-normal">{{ $item->created_at }}</th>

                                </tr>
                            @endforeach
                        @else
                            @foreach ($LogQuantity as $item)
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $item->name }}</th>
                                    <th class="fw-normal">{{ $item->action }}</th>
                                    <th class="fw-normal">{{ $item->created_at }}</th>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($this->altTable == true)
                {{ $LogHisto->links() }}
            @else
                {{ $LogQuantity->links() }}
            @endif

        </div>
    </main>
</div>
