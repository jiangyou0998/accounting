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
                    <th>打印預覽</th>
                    <th>按比例</th>
                    <th>一車</th>
                    <th>二車</th>
                    <th>總</th>

                </tr>

                @foreach($cats as $cat)
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
            <div class='col-sm-4'></div>
        </div>

    </div>
    <input type="hidden" name="downstr" id="downstr" value=""/>
</div>

<script>

    function viewPrint(id, type = 0) {
        var delidate = $('#datepicker').val();

        // alert(delidate);
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }

        var dateTime = new Date(delidate);
        // dateTime = dateTime.setDate(dateTime.getDate() - numofday);

        var url = '';
        url = '{{route('admin.order_print')}}' + '?cat_id=' + id + '&deli_date=' + delidate + '&type=' + type;
        window.open(url);
    }

    function viewPrintRate(id) {
        var delidate = $('#datepicker').val();

        // alert(delidate);
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }

        var dateTime = new Date(delidate);
        // dateTime = dateTime.setDate(dateTime.getDate() - numofday);

        var url = '';
        url = '{{route('admin.order_print_rate')}}' + '?cat_id=' + id + '&deli_date=' + delidate;
        window.open(url);
    }

    //鉤選或取消時,修改weekstr(隱藏)的值
    $(document).on('change', 'input[type=checkbox]', function () {
        var downstr = $('input[type=checkbox]:checked').map(function () {
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
                //默認當前日期+2天,有cutday加相應天數
                defaultDate : '{{\Carbon\Carbon::now()->addDay(request()->cutday ?? 2)->toDateString()}}',
                // icon : 'glyphicon glyphicon-calendar',

            });
        });
    });

</script>


