@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __("Role List") }}</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-form-add">{{ __('Add') }}</button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Slug') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col" class="text-center">{{ __('Users') }}</th>
                                    <th scope="col" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $roles as $i => $role )
                                    <tr>
                                        <th class="align-middle" scope="row">{{ $i + 1 }}</th>
                                        <td class="align-middle">{{ $role->name }}</td>
                                        <td class="align-middle">{{ $role->slug }}</td>
                                        <td class="align-middle">{{ $role->description }}</td>
                                        <td class="align-middle text-center">{{ count( $role->users ) }}</td>
                                        <td class="align-middle text-center">
                                            <button type="button" class="btn-edit btn btn-link text-secondary shadow-none" data-toggle="modal" data-target="#modal-form-edit" data-name="{{ $role->name }}" data-slug="{{ $role->slug }}" data-description="{{ $role->description }}" data-url="{{ route('role.update', $role->id) }}"><i class="fa fa-pencil"></i></a>
                                            @if ( $role->isDeletable() )
                                                <button type="button" class="btn btn-link text-danger shadow-none" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $role->name }}" data-url="{{ route('role.destroy', $role->id) }}"><i class="fa fa-times"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Form Add Role --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title" id="modal-add-title">{{ __('New Role') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('role.store') }}" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <label>{{ __('Role Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}</label>
                            <input type="text" name="slug" class="form-control" placeholder="{{ __('Slug') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="{{ __('Description') }}"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal Form Edit Role --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title" id="modal-add-title">{{ __('Edit Role') }}</p>
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
                            <label>{{ __('Role Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}</label>
                            <input type="text" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="{{ __('Description') }}"></textarea>
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
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Delete Role') }} <span class="name"></span></p>
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

        // Autoset slug on empty after input name
        $('input[name=name]').on('blur', function() {
            let formattedSlug = _.kebabCase( $(this).val() );
            let inputSlug = $(this).closest('form').find('input[name=slug]');

            if ( inputSlug.val() == '' ) inputSlug.val(formattedSlug);
        })

        // Force input slug string in camel case
        $('input[name=slug]').on('blur', function() {
            let formattedSlug = _.kebabCase( $(this).val() );
            $(this).val(formattedSlug);
        })

        // Autofocus input on modal show
        $('#modal-form-add, #modal-form-edit').on('shown.bs.modal', function () {
            $(this).find('input[name=name]').trigger('focus');
        })

        // Add Role - Ajax Process
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
                    console.log('Failed submit new role: ', status, response);
                }
            })
        })

        // Edit Role Modal Function
        $('#modal-form-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let slug = button.data('slug');
            let description = button.data('description');
            let url = button.data('url');

            $(this).find('form').attr('action', url);
            $(this).find('input[name=name]').val(name);
            $(this).find('input[name=slug]').val(slug);
            $(this).find('textarea[name=description]').val(description);
        })

        // Edit Role - Ajax Process
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
                    console.log('Failed edit role: ', status, response);
                }
            })
        })

        // Delete Role Modal Function
        $('#modal-form-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');

            $(this).find('form').attr('action', url);
            $(this).find('.name').html(name);
        })

    </script>
@endpush
