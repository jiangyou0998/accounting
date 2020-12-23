<style>

    .cssMenu {
        list-style-type: none;
        padding: 0;
        overflow: hidden;
        background-color: #ECECEC;
        float: right;
    }

    .cssMenuItem {
        float: right;
        width: 140px;
        border-right: 2px solid white;
    }

    .cssMenuItem a {
        display: block;
        color: black;
        text-align: center;
        padding: 4px;
        text-decoration: none;
    }

    .cssMenuItem a:hover {
        background-color: #BBBBBB;
        color: white;
    }

    .cssImportant {
        background-color: #CCFFFF
    }

    .cssTable1 {
        border-collapse: collapse;
    }

    .cssTable1 {
        border: 2px solid black;
    }

    .cssTable1 th {
        padding: 0px;
        text-align: center;
        border: 2px solid black;
        width: 100px;
    }

    .cssTable1 td {
        padding: 0px;
        text-align: center;
        border: 2px solid black;
    }

    -->
    #downselect{
        zoom:180%;
    }


    #loading {
        position: fixed;
        z-index: 400;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0%;
        text-align: center;
        color: #595758;
        background-color: #ffffff;
        font-size: 250%;
    }
</style>

<div align="center" width="100%">
    <div align="center" style="width:850px;">

        <form id="sort" method="POST">
            <input type="hidden" name="Sort" value="1">

            <table class="cssTable1" id="table1">
                <tr class="cssImportant">
                    <th style="width:50px;">#</th>
                    <th style="width:300px;">報告名稱</th>
{{--                    <th>相隔日數</th>--}}
{{--                    <th>報表時間</th>--}}
{{--                    <th>查看</th>--}}
                    <th>打印預覽</th>
                    <th>
                        <span id="spanss">全選</span>
                        <input class="check-all" type="checkbox" onclick="checkAll()">
                    </th>
                </tr>

                @foreach($checks as $check)
                    @include('admin.production._table_data')
                @endforeach


        </table>
        </form>

        <div class="input-group input-group-sm" style="margin-top: 15px;">
            <div class='col-sm-4'></div>
            <div class="col-sm-4 input-group-prepend" >
                <span class="input-group-text bg-white text-capitalize"><b>報表時間</b>&nbsp;<i class="feather icon-calendar"></i></span>
                <input id='datepicker' autocomplete="off" type="text" class="form-control" id="filter_column__insert_date_start" placeholder="插入時間" name="insert_date[start]" value="">
            </div>
            <div class='col-sm-4'>
                <a href="javascript:;" target="_blank" onclick="createReportSelected()">批量預覽</a>
            </div>
        </div>

    </div>
    <input type="hidden" name="downstr" id="downstr" value=""/>
</div>

<script>


    function viewPrint(id, numofday) {
        var delidate = $('#datepicker').val();

        // alert(delidate);
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }

        var dateTime = new Date(delidate);
        // dateTime = dateTime.setDate(dateTime.getDate() - numofday);

        var url = '';
        {{--url = '{{route('admin.order_print')}}' + '?cat_id=' + id + '&deli_date=' + delidate;--}}
        url = '{{route('admin.order_print')}}' + '?check_id=' + id + '&deli_date=' + delidate;
        window.open(url);
    }

    function createReportSelected(){
        var isSelectedTime = true;
        var delidate = $('#datepicker').val();
        var downstr = $('#downstr').val();
        if (delidate == '') {
            alert('請選擇收貨日期!');
            isSelectedTime = false;
            return false;
        }
        if (downstr == '') {
            alert('請選擇要生成的報表!');
            isSelectedTime = false;
            return false;
        }
        // $('#loading').show();
        {{--window.location.href = "{{route('admin.order_print')}}?deli_date=" + delidate + "&check_id=" + downstr;--}}
        if(isSelectedTime){
            window.open("{{route('admin.order_print')}}?deli_date=" + delidate + "&check_id=" + downstr);
        }
    }

    //全選/反選
    function checkAll(){
        if($(".check-all").prop("checked")){    //判斷check_all是否被選中
            $("input[class='downselect']").prop("checked",true);//全選
            $("#spanss").html("取消");
        }else{
            $("input[class='downselect']").prop("checked",false); //反選
            $("#spanss").html("全选");
        }
    }

    //鉤選或取消時,修改downstr(隱藏)的值
    $(document).on('change', 'input[type=checkbox],.downselect', function () {
        var downstr = $('.downselect:checked').map(function () {
            return this.value
        }).get().join(',');
        $('#downstr').val(downstr);
        // alert(weekstr);
    });

    Dcat.ready(function () {
        $(function () {
            $('#datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                "locale":"zh-TW",
                defaultDate : '{{\Carbon\Carbon::now()->addDay(2)->toDateString()}}',
                // icon : 'glyphicon glyphicon-calendar',

            });
        });
    });

    // $(window).load(function () {
    //     $('#loading').hide();
    // });

</script>


