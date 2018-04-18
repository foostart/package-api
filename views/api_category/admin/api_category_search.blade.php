
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i><?php echo trans('api::api_admin.page_search') ?></h3>
    </div>
    <div class="panel-body">

        {!! Form::open(['route' => 'admin_api_category','method' => 'get']) !!}

        <!--TITLE-->
		<div class="form-group">
            {!! Form::label('api_category_name',trans('api::api_admin.api_category_name_label')) !!}
            {!! Form::text('api_category_name', @$params['api_category_name'], ['class' => 'form-control', 'placeholder' => trans('api::api_admin.api_category_name')]) !!}
        </div>

        {!! Form::submit(trans('api::api_admin.search').'', ["class" => "btn btn-info pull-right"]) !!}
        {!! Form::close() !!}
    </div>
</div>




