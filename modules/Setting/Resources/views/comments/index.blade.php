@extends('backend.layouts.app')
@section('title', localize('comments_list'))
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('comments_list') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">{{ localize('sl') }}</th>
                            <th width="25%">{{ localize('email') }}</th>
                            <th width="20%">{{ localize('comments') }}</th>
                            <th width="15%">{{ localize('news_id') }}</th>
                            <th width="15%">{{ localize('status') }}</th>
                            <th width="15%">{{ localize('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dbData as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->comments }}</td>
                                <td>{{ $data->news_id }}</td>
                                <td>
                                    @php  
                                        if($data->com_status==1){ 
                                    @endphp
                                        <span class="btn btn-info  mb-2 mr-1">{{localize('verified')}} </span>
                                    @php  
                                        }else{
                                    @endphp
                                        <span class="btn btn-danger  mb-2 mr-1">{{localize('not_verified')}} </span>
                                    @php  
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @can('update_comment')
                                        @if($data->com_status == 1)
                                            <a href="{{ url('comments/comments_manage/update/' . $data->com_id) }}" class='btn btn-sm btn-success'>
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('comments/comments_manage/update/' . $data->com_id) }}" class='btn btn-sm btn-danger'>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    @endcan

                                    @can('delete_comment')
                                        <a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm"
                                            data-bs-toggle="tooltip" title="Delete"
                                            data-route="{{ route('comments.destroy', $data->id) }}"
                                            data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ localize('empty_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
