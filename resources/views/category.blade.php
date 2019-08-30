@extends('master')

@section('title', '书籍类别')

@section('content')
<div class="weui_cells_title">选择书籍类别</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select name="category" class="weui_select">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>



    <div class="weui_cells weui_cells_access">
        <a href="javascript:;" class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <p>cell standard</p>
            </div>
            <div class="'weui_cell_ft">说明文字</div>
        </a>
        <a href="javascript:;" class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <p>cell standdard</p>
            </div>
            <div class="'weui_cell_ft">说明文字</div>
        </a>

    </div>
@endsection

@section('my-js')

    <script type="text/javascript">

        _getCategory();

        $('.weui_select').change(function(event){
           _getCategory();
        });

        function _getCategory() {
            var parent_id = $('.weui_select option:selected').val();

            $.ajax({
                url: '/service/category/parent_id/'+ parent_id,
                type:"GET",
                dataType: 'json',
                cache: false,

                success: function(data) {
                    if(data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }
                    if(data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }
                    console.log(data);
                    //将查询到的东西遍历输出
                    $('.weui_cells_access').html('');
                    for(var i=0;i<data.categorys.length;i++){
                        var next = '/product/category_id/'+data.categorys[i].id;
                        var node =   '<a href="'+next+'" class="weui_cell">'+
                                     '<div class="weui_cell_bd weui_cell_primary">'+
                                     '<p>'+data.categorys[i].name+'</p>'+
                                    '</div>'+
                                    '<div class="weui_cell_ft"></div>'+
                                     '</a>';
                        $('.weui_cells_access').append(node);

                    }

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });

        }




    </script>

@endsection