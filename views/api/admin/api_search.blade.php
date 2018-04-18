
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i><?php echo trans('api::api_admin.page_search') ?></h3>
    </div>
    <div class="panel-body">

        {!! Form::open(['route' => 'admin_api','method' => 'get']) !!}

        <!--TITLE-->
        <div class="form-group">
            {!! Form::label('api_name', trans('api::api_admin.api_name_label')) !!}
            {!! Form::text('api_name', @$params['api_name'], ['class' => 'form-control', 'placeholder' => trans('api::api_admin.api_name_placeholder')]) !!}
        </div>
        <!--/END TITLE-->

        {!! Form::submit(trans('api::api_admin.search').'', ["class" => "btn btn-info pull-right"]) !!}
        {!! Form::close() !!}
    </div>
</div>


