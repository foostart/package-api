
@if( ! $apis->isEmpty() )
<table class="table table-hover">
    <thead>
        <tr>
            <td style='width:5%'>{{ trans('api::api_admin.order') }}</td>
            <th style='width:10%'>Api ID</th>
            <th style='width:50%'>Api title</th>
            <th style='width:20%'>{{ trans('api::api_admin.operations') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $nav = $apis->toArray();
            $counter = ($nav['current_page'] - 1) * $nav['per_page'] + 1;
        ?>
        @foreach($apis as $api)
        <tr>
            <td>
                <?php echo $counter; $counter++ ?>
            </td>
            <td>{!! $api->api_id !!}</td>
            <td>{!! $api->api_name !!}</td>
            <td>
                <a href="{!! URL::route('admin_api.edit', ['id' => $api->api_id]) !!}"><i class="fa fa-edit fa-2x"></i></a>
                <a href="{!! URL::route('admin_api.delete',['id' =>  $api->api_id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete"><i class="fa fa-trash-o fa-2x"></i></a>
                <span class="clearfix"></span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
 <span class="text-warning">
	<h5>
		{{ trans('api::api_admin.message_find_failed') }}
	</h5>
 </span>
@endif
<div class="paginator">
    {!! $apis->appends($request->except(['page']) )->render() !!}
</div>