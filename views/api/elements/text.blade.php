<!-- api NAME -->
<div class="form-group">
    <?php $api_name = $request->get('api_titlename') ? $request->get('api_name') : @$api->api_name ?>
    {!! Form::label($name, trans('api::api_admin.name').':') !!}
    {!! Form::text($name, $api_name, ['class' => 'form-control', 'placeholder' => trans('api::api_admin.name').'']) !!}
</div>
<!-- /api NAME -->