@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Evaluate Users</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Evaluates</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Evaluates</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
            $('body').on('change', '.evalute-status', function() {
                let id = $(this).data('id');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.evaluate.update', ':id') }}'.replace(':id', id),
                    data: {},
                    success: function(response) {
                        if (response.status === 'success')
                            toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
