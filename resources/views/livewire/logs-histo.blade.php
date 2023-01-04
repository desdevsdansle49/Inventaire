<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">

        <h2 class="mt-2 mb-5 text-center">Historique</h2>

        <div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="th1"></th>
                            <th class="th2">Nom</th>
                            <th class="th3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <th></th>
                                <th class="fw-normal">{{ $item->name }}</th>
                                <th class="fw-normal">{{ $item->action }}</th>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $items->links() }}
        </div>
    </main>
</div>
