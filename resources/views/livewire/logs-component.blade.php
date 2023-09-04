<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <h2 class="mt-2 mb-5 text-center">Historique</h2>

        <input class="ms-3 me-1 mb-3" wire:model='altTable'type="checkbox" id="histo" name="histo">
        <label for="histo">Historique des modifications</label>
        <div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="th1" style="padding: 0%"></th>
                            <th class="th6">Nom</th>
                            <th class="th3">Action</th>
                            <th>Temps</th>
                            @if ($this->altTable == false)
                                <th>qui</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($this->altTable == true)
                            @foreach ($LogHisto as $item)
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $item->name }}</th>
                                    <th class="fw-normal">{{ $item->action }}</th>
                                    <th class="fw-normal">{{ $item->formatted_created_at }}</th>

                                </tr>
                            @endforeach
                        @else
                            @foreach ($LogQuantity as $item)
                                <tr>
                                    <th></th>
                                    <th class="fw-normal">{{ $item->name }}</th>
                                    <th class="fw-normal">{{ $item->action }}</th>
                                    <th class="fw-normal">{{ $item->formatted_created_at }}</th>
                                    <th class="fw-normal">{{ $item->department_id }}</th>
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
