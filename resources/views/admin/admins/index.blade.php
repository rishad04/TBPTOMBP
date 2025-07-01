@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')
    <div class="myy-table">
        <div class="myy-table__wrapper">
            <div class="myy-table__header d-flex justify-content-between">
                <div class="myy-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div>
                    @can('admin-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                            <i class="flaticon2-add"></i>

                            {{ $info->first_button_title }}
                        </a>
                    @endcan
                </div>
            </div>
            <div class="myy-table__body table-responsive">
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th>{{ __('field.avatar') }}</th>
                            <th>{{ __('field.name') }}</th>
                            <th>{{ __('field.email') }}</th>
                            <th>{{ __('field.phone') }}</th>
                            <th>{{ __('column.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $serial = 1;
                        @endphp

                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $serial }}</td>
                                <td>
                                    <div class="myy-item d-flex gap-2">
                                        <div class="myy-thumb thumb-md">
                                            <img src="@if ($row->avatar != '') {{ asset($row->avatar) }} @else {{ asset(avatarUrl()) }} @endif"
                                                alt="avatar">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>
                                    <ul class="myy-action__list">
                                        <li class="myy-action">
                                            <a href="{{ route('admin.admins.show', $row->id) }}"
                                                class="myy-action__item myy-action__item--success">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                        </li>

                                        @can('admin-update')
                                            <li class="myy-action">
                                                <a href="{{ route('admin.admins.edit', $row->id) }}"
                                                    class="myy-action__item myy-action__item--warning">
                                                    <i class="lni lni-pencil-alt"></i>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('admin-delete')
                                            <li class="myy-action">
                                                <a onclick="deleteCrudItem(`{{ route('admin.admins.destroy', $row->id) }}`)"
                                                    class="myy-action__item myy-action__item--danger">
                                                    <i class="lni lni-trash-can"></i>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>

                                </td>
                            </tr>
                            @php
                                $serial++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection
