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
                    <th>全選
                        <!-- <input type="checkbox" οnclick="checkAll()"> -->
                    </th>
                </tr>

                @foreach($cats as $cat)
                    @include('admin.production._table_data')
                @endforeach


        </table>
        </form>
{{--        <div><span>收貨時間:</span>--}}
{{--            <input type="text" name="checkDate"--}}
{{--                   class="forms-control"--}}
{{--                   value=""--}}
{{--                   id="datepicker"--}}
{{--                   onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" --}}
{{--                   readonly>--}}

{{--            <a href="#" style=" font-size:150%;" onclick="createReport()">生成全部報表</a><br><br>--}}
{{--            <a href="#" style=" font-size:150%;" onclick="createReportSelected()">生成選擇報表</a>--}}
{{--        </div>--}}

{{--        <div class="row" style="margin-top: 15px;">--}}
{{--            <div class='col-sm-4'></div>--}}
{{--            <div class='col-sm-4'>--}}
{{--                <div class="forms-group">--}}
{{--                    <div class='input-group date' id='datetimepicker'>--}}
{{--                        <span style="font-size: larger;text-align:center;">報表時間&nbsp&nbsp:&nbsp&nbsp</span>--}}
{{--                        <input type='text' class="forms-control" id='datepicker'/>--}}
{{--                        <span class="input-group-addon">--}}
{{--                            <span class="glyphicon glyphicon-calendar"></span>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class='col-sm-4'></div>--}}
{{--            <script type="text/javascript">--}}
{{--                $(function () {--}}
{{--                    $('#datetimepicker').datetimepicker({--}}
{{--                        format: 'YYYY-MM-DD',--}}
{{--                        "locale":"zh-TW",--}}
{{--                        defaultDate : '{{\Carbon\Carbon::now()->addDay('2')->toDateString()}}',--}}
{{--                        // icon : 'glyphicon glyphicon-calendar',--}}

{{--                    });--}}
{{--                });--}}

{{--            </script>--}}
{{--        </div>--}}

        <div class="input-group input-group-sm" style="margin-top: 15px;">
            <div class='col-sm-4'></div>
            <div class="col-sm-4 input-group-prepend" >
                <span class="input-group-text bg-white text-capitalize"><b>報表時間</b>&nbsp;<i class="feather icon-calendar"></i></span>
                <input id='datepicker' autocomplete="off" type="text" class="form-control" id="filter_column__insert_date_start" placeholder="插入時間" name="insert_date[start]" value="">
            </div>
            <div class='col-sm-4'></div>
        </div>

        <script type="text/javascript">
            $(function () {
                $('#datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                    "locale":"zh-TW",
                    defaultDate : '{{\Carbon\Carbon::now()->addDay('2')->toDateString()}}',
                    // icon : 'glyphicon glyphicon-calendar',

                });
            });

        </script>

    </div>
    <input type="hidden" name="downstr" id="downstr" value=""/>
</div>
<div id='loading'>報表正在生成中...</div>

<script>
    function viewReport(id, numofday) {
        var delidate = $('#datepicker').val();

        // alert(delidate);
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }

        var dateTime = new Date(delidate);
        dateTime = dateTime.setDate(dateTime.getDate() - numofday);
        var url = '';
        url = 'CMS_order_c_check_m.php?id=' + id + '&checkDate=' + formatDate(dateTime);
        window.open(url);
    }

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
        url = '{{route('admin.order_print')}}' + '?cat_id=' + id + '&deli_date=' + delidate;
        window.open(url);
    }

    // 第三种方式：函数处理
    function formatDate(now) {
        var date = new Date(now);
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var date = date.getDate();
        if (month < 10) {
            month = '0' + month;
        }
        if (date < 10) {
            date = '0' + date;
        }
        return year + "-" + month + "-" + date;
    }

    function createReport() {
        // alert(111);
        var isSelectedTime = true;
        var delidate = $('#datepicker').val();
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }
        $('#loading').show();
        window.location.href = "down_history_report.php?dTime=" + delidate;

    }

    function createReportSelected(){
        var isSelectedTime = true;
        var delidate = $('#datepicker').val();
        var downstr = $('#downstr').val();
        if (delidate == '') {
            alert('請選擇收貨日期!');
            return false;
        }
        if (downstr == '') {
            alert('請選擇要生成的報表!');
            return false;
        }
        $('#loading').show();
        window.location.href = "down_selected_report.php?dTime=" + delidate + "&checkids=" + downstr;
    }

    function checkAll(){
        // $("#downselect").prop('checked', $(obj).prop('checked'));
        if($("#downselect :checked")){
            if(b){
                $("input[class='downselect']").each(function(){
                    this.checked=true;
                    //获取当前值
                    //alert($(this).val());
                });
                $("#spanss").html("取消");
                b=false;
            }else{
                $("input[class='downselect']").each(function(){
                    this.checked=false;
                    //获取当前值
                    //alert($(this).val());
                });
                $("#spanss").html("全选");
                b=true;
            }

        }

    }

    //鉤選或取消時,修改weekstr(隱藏)的值
    $(document).on('change', 'input[type=checkbox]', function () {
        var downstr = $('input[type=checkbox]:checked').map(function () {
            return this.value
        }).get().join(',');
        $('#downstr').val(downstr);
        // alert(weekstr);
    });


    $(document).ready(function () {
        $('#loading').hide();
    });

    // $(window).load(function () {
    //     $('#loading').hide();
    // });

</script>


