<!--ADD api CATEGORY ITEM-->
<div class="row margin-bottom-12">
    <div class="col-md-12">
        <a href="{!! URL::route('admin_api_category.edit') !!}" class="btn btn-info pull-right">
            <i class="fa fa-plus"></i>{{trans('api::api_admin.api_category_add_button')}}
        </a>
    </div>
</div>
<!--/END ADD api CATEGORY ITEM-->

@if( ! $apis_categories->isEmpty() )
<table class="table table-hover">
    <thead>
        <tr>
            <td style='width:5%'>
                {{ trans('api::api_admin.order') }}
            </td>

            <th style='width:10%'>
                {{ trans('api::api_admin.api_categoty_id') }}
            </th>

            <th style='width:50%'>
                {{ trans('api::api_admin.api_categoty_name') }}
            </th>

            <th style='width:20%'>
                {{ trans('api::api_admin.operations') }}
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            $nav = $apis_categories->toArray();
            $counter = ($nav['current_page'] - 1) * $nav['per_page'] + 1;
        ?>
        @foreach($apis_categories as $api_category)
        <tr>
            <!--COUNTER-->
            <td>
                <?php echo $counter; $counter++ ?>
            </td>
            <!--/END COUNTER-->

            <!--api CATEGORY ID-->
            <td>
                {!! $api_category->api_category_id !!}
            </td>
            <!--/END api CATEGORY ID-->

            <!--api CATEGORY NAME-->
            <td>
                {!! $api_category->api_category_name !!}
            </td>
            <!--/END api CATEGORY NAME-->

            <!--OPERATOR-->
            <td>
                <a href="{!! URL::route('admin_api_category.edit', ['id' => $api_category->api_category_id]) !!}">
                    <i class="fa fa-edit fa-2x"></i>
                </a>
                <a href="{!! URL::route('admin_api_category.delete',['id' =>  $api_category->api_category_id, '_token' => csrf_token()]) !!}"
                   class="margin-left-5 delete">
                    <i class="fa fa-trash-o fa-2x"></i>
                </a>
                <span class="clearfix"></span>
            </td>
            <!--/END OPERATOR-->
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <!-- FIND MESSAGE -->
    <span class="text-warning">
        <h5>
            {{ trans('api::api_admin.message_find_failed') }}
        </h5>
    </span>
    <!-- /END FIND MESSAGE -->
@endif
<div class="paginator">
    {!! $apis_categories->appends($request->except(['page']) )->render() !!}
</div>