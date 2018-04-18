<!-- api NAME -->
<div class="form-group">
    <?php $api_category_name = $request->get('api_titlename') ? $request->get('api_name') : @$api->api_category_name ?>
    {!! Form::label($name, trans('api::api_admin.name').':') !!}
    {!! Form::text($name, $api_category_name, ['class' => 'form-control', 'placeholder' => trans('api::api_admin.name').'']) !!}
</div>
<!-- /api NAME -->