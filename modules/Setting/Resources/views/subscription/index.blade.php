@extends('backend.layouts.app')
@section('title', localize('subscription_list'))
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('subscription_list') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">{{ localize('sl') }}</th>
                            <th width="25%">{{ localize('name') }}</th>
                            <th width="20%">{{ localize('email') }}</th>
                            <th width="15%">{{ localize('phone') }}</th>
                            <th width="15%">{{ localize('category') }}</th>
                            <th width="15%">{{ localize('number_of_news') }}</th>
                            <th width="15%">{{ localize('payment_status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dbData as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>{{ $data->category_name }}</td>
                                <td>{{ $data->number_of_news }}</td>
                                <td>
                                    @php  
                                        if($data->payment_status==1){ 
                                    @endphp
                                        <span class="btn btn-info  mb-2 mr-1">{{localize('paid')}} </span>
                                    @php  
                                        }else{
                                    @endphp
                                        <span class="btn btn-danger  mb-2 mr-1">{{localize('unpaid')}} </span>
                                    @php  
                                        }
                                    @endphp
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
