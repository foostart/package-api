@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: {{ trans('api::api_admin.page_list') }}
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title bariol-thin"><i class="fa fa-group"></i> {!! 'Api' !!}</h3>
                </div>
                <div class="panel-body">
                    Admin Api
               </div>
           </div>
        </div>
        <div class="col-md-4">
            @include('api::api.admin.api_search')
        </div>
    </div>
</div>
@stop