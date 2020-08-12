@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __("Polyclinic List") }}</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-form-add">{{ __('Add') }}</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col" class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $polyclinics as $i => $item )
                                <tr>
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $item->value }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn-edit btn btn-link text-secondary shadow-none" data-toggle="modal" data-target="#modal-form-edit" data-name="{{ $item->value }}" data-url="{{ route('polyclinic.update', $item->id) }}"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="btn btn-link text-danger shadow-none" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $item->value }}" data-url="{{ route('polyclinic.destroy', $item->id) }}"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Form Add Polyclinic --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title" id="modal-add-title">{{ __('New Polyclinic') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('polyclinic.store') }}" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <input type="text" name="polyclinic" class="form-control" placeholder="{{ __('Name') }}" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal Form Edit Polyclinic --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title" id="modal-add-title">{{ __('Edit Polyclinic') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <input type="text" name="polyclinic" class="form-control" placeholder="{{ __('Name') }}" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal Form Delete Polyclinic --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Delete') }} <span class="name"></span></p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-danger btn-block">{{ __('Yes') }}</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">{{ __('No') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Custom Script --}}
@push('footer-after-script')
    <script>

        // Add Polyclinic - Autofocus input on modal show
        $('#modal-form-add').on('shown.bs.modal', function () {
            $(this).find('input[name="polyclinic"]').trigger('focus')
        })

        // Add Polyclinic - Ajax Process
        $('#modal-form-add form').on('submit', function(event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            let targetUrl = $(this).attr('action');
            $.ajax({
                data: formData,
                method: 'post',
                url: targetUrl,
                beforeSend: function() {},
                success: function(response, status) {
                    window.location = ''; // Reload page
                },
                error: function(xhr, status, response) {
                    console.log('Failed submit new polyclinic: ', status, response);
                }
            })
        })

        // Edit Polyclinic Modal Function
        $('#modal-form-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');

            $(this).find('form').attr('action', url);
            $(this).find('input[name="polyclinic"]').val(name);
        })

        // Edit Polyclinic - Autofocus input on modal show
        $('#modal-form-edit').on('shown.bs.modal', function (event) {
            $(this).find('input[name="polyclinic"]').trigger('focus');
        })

        // Edit Polyclinic - Ajax Process
        $('#modal-form-edit form').on('submit', function(event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            let targetUrl = $(this).attr('action');
            $.ajax({
                data: formData,
                method: 'patch',
                url: targetUrl,
                beforeSend: function() {},
                success: function(response, status) {
                    window.location = ''; // Reload page
                },
                error: function(xhr, status, response) {
                    console.log('Failed edit polyclinic: ', status, response);
                }
            })
        })

        // Delete Polyclinic Modal Function
        $('#modal-form-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');

            $(this).find('form').attr('action', url);
            $(this).find('.name').html(name);
        })

    </script>
@endpush
