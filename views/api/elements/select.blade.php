<!-- CATEGORY LIST -->
<div class="form-group">
    <?php $api_name = $request->get('api_titlename') ? $request->get('api_name') : @$api->api_name ?>

    {!! Form::label('category_id', trans('api::api_admin.api_categoty_name').':') !!}
    {!! Form::select('category_id', @$categories, @$api->category_id, ['class' => 'form-control']) !!}
</div>
<!-- /CATEGORY LIST -->