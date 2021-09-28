@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css"
          id="theme-styles">
@stop

@section('js')
{{--    bootstrap-fileinput--}}
    <link href="/vendors/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="/vendors/bootstrap-fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet"
          type="text/css"/>
    <script src="/vendors/bootstrap-fileinput/js/plugins/piexif.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/js/locales/zh-TW.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/themes/fas/theme.js" type="text/javascript"></script>
    <script src="/vendors/bootstrap-fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>
{{--    layui--}}
    <script src="../layui/layui.all.js"></script>
{{--    select2--}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

{{--<script src="//res.layui.com/layui/dist/layui.js?t=1631518058775"></script>--}}
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">--}}
@endsection

@section('style')
    <style type="text/css">
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            line-height: calc(2.25rem + 2px);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: calc(2.25rem + 2px);
        }

        .layui-icon {
            font-family: layui-icon!important;
            font-size: 16px;
            font-style: normal;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>醫療索償</h2>
        </div>

{{--        頂部索償數據查詢--}}
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h4 class="border-bottom border-gray pb-2 mb-0"><b>索償數據</b></h4>

            <div class="media text-muted pt-3">
                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>

                <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">本年索償次數(已批准)</strong>
                    <span id="times_of_year"></span>次
                </p>

                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>

                <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">索償上限次數</strong>
                    <span id="times_per_year"></span>次
                </p>
            </div>

            <div class="media text-muted pt-3">
                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6f42c1"></rect><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>

                <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">索償類型</strong>
                    <span id="claim_type">/</span>
                </p>
                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6f42c1"></rect><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>

                <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">Rate</strong>
                    <span id="rate"></span>%
                </p>
            </div>
{{--            <div class="media text-muted pt-3">--}}
{{--                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>--}}

{{--                <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">--}}
{{--                    <strong class="d-block text-gray-dark">索償金額上限</strong>--}}
{{--                    HKD$<span id="max_claim_money"></span>--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <small class="d-block text-right mt-3">--}}
{{--                <a href="#">All updates</a>--}}
{{--            </small>--}}
        </div>
{{--        頂部索償數據查詢--}}

{{--        表單--}}
        <div id="page-wrapper">
            <form class="needs-validation" novalidate="" method="post" action="{{route('claim.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="employee">員工</label>
                        <select class="form-control custom-select d-block w-100" id="employee" name="employee" required="">
                            <option value="">-- 請選擇名稱 --</option>
                            @foreach($employees as $key => $value)
                                <option value="{{$value->id}}">{{$value->code_and_name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            請選擇「員工名稱」
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state">索償類型</label>
                        <select class="custom-select d-block w-100" name="claim_level_id" id="claim_level_id" required="">
                            <option value="">-- 請先選擇員工 --</option>
                        </select>
                        <div class="invalid-feedback">
                            請選擇「索償類型」
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="claim_illness">病症</label>
                        <select class="custom-select d-block w-100" name="claim_illness" id="claim_illness" required="">
                            <option value="">-- 請選擇病症 --</option>
                            @foreach($claim_illness as $key => $value)
                                <option value="{{$key}}" @if(old('claim_illness') == $key) selected @endif>{{$value}} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            請選擇「病症」
                        </div>
                    </div>
                </div>
                <hr class="mb-4">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="cost">花費</label>
                        <input type="number" class="form-control" name="cost" id="cost" value="{{ old('cost') ?? '' }}" autocomplete="off" placeholder="" required="">
                        <div class="invalid-feedback">
                            請填寫「花費」
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="claim_date">診症日期</label>

                        <input type="text" class="form-control layui-input d-block w-100" name="claim_date" id="claim_date" value="{{ old('claim_date') ?? '' }}" autocomplete="off" required="">

                        <div class="invalid-feedback">
                            請填寫「診症日期」
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input class="form-control layui-input d-block w-100" name="file" id="file" type="file" class="file" data-preview-file-type="text">
                    </div>

                    <div class="invalid-feedback">
                        請填寫「診症日期」
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="submit" disabled>提交</button>
                </div>
            </form>
        </div>
        <!-- /. PAGE WRAPPER  -->
        <hr class="mb-4">
{{--        表單--}}


        <script type="text/javascript">
            $(document).ready(function () {

                $('#employee').select2();

                var employees = @json($employees->pluck('claim_level', 'id'));

                //绑定分类下拉框选项变化事件
                $("#employee").on('change',
                    function () {
                        var items = $(this).val();
                        var claim_id = employees[items];
                        $('#claim_level_id').val('').trigger('change');

                        if (items == '') {
                            $("#claim_level_id").empty().append('<option value="" >-- 請先選擇員工 --</option>');
                            return;
                        }

                        var claim_levels = @json($claim_levels);

                        var projectsMap = {};
                        var projectsMap = claim_levels[claim_id];

                        // console.log(employees[items]);
                        // console.log(projectsMap);

                        var option = "";
                        for (var i in projectsMap) {
                            for (var j in projectsMap[i]) {
                                option += '<option value="' + j + '"  >' + projectsMap[i][j] + '</option>';
                            }
                            // option += '<option value="' + i + '"  >' + projectsMap[i] + '</option>';
                        }

                        $("#claim_level_id").empty().append('<option value="" >請選擇</option>' + option);


                    });

                //如有舊表單數據,選中"員工"框並觸發
                $('#employee').val({{ old('employee' ?? '') }});
                $('#employee').trigger('change');

                $("#claim_level_id").on('change',
                    function () {

                        var employee_id = $("#employee").val();
                        var claim_level_id = $(this).val();

                        if(claim_level_id === '') return;

                        $.ajax({
                            type: "POST",
                            url: "{{ route('claim.message') }}",
                            dataType: 'json',
                            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                "employee_id": employee_id,
                                "claim_level_id": claim_level_id,
                            },
                            success: function (data) {
                                console.log(data);
                                $("#times_of_day_applying").text(data.times_of_day_applying);
                                $("#times_of_year").text(data.times_of_year);
                                $("#times_per_year").text(data.times_per_year);
                                $("#claim_type").text(data.claim_type);
                                $("#rate").text(data.rate);
                                // $("#max_claim_money").text(data.max_claim_money);
                            },
                            error: function(request, status, error){
                                // alert(error);
                            },
                        });




                    });

                //如有舊表單數據,選中"索償類型"框並觸發
                $('#claim_level_id').val({{ old('claim_level_id' ?? '') }});
                $('#claim_level_id').trigger('change');
            });

            //
            // ;!function(){
            //     //无需再执行layui.use()方法加载模块，直接使用即可
            //     var form = layui.form
            //         ,layer = layui.layer;
            //
            //     //…
            // }();

            layui.use('laydate', function(){
                var laydate = layui.laydate;

                //执行一个laydate实例
                laydate.render({
                    elem: '#claim_date' //指定元素
                    ,min: -90 //90天前
                    ,max: 0 //今日
                });
            });

            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            //判斷是否通過驗證
                            var is_valid = form.checkValidity();
                            //必須上傳文件
                            if (document.getElementById("file").value === "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: "請上傳文件！",
                                });
                                is_valid = false;
                            }

                            if (is_valid === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }else if (is_valid === true) {
                                //2020-12-08 認證成功禁止按鈕再次點擊
                                document.getElementById("submit").disabled = true;
                            }

                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
                document.getElementById("submit").disabled = false;
            })();

            $("#file").fileinput({
                theme: 'fas',
                language: 'zh-TW',
                uploadUrl: '#', // you must set a valid URL here else you will get an error
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg' ],
                overwriteInitial: false,
                showUpload: false,
                showUploadedThumbs: false,
                // dropZoneEnabled: false,
                maxFileSize: 10000,
                maxFilesNum: 10,
                required: true,
                {{--uploadUrl: '{{route('itsupport.upload')}}',--}}
                //allowedFileTypes: ['image', 'video', 'flash'],
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });

            $(function () {
                $("[data-toggle='popover']").popover({
                    trigger: 'hover'
                });
            });

            // $(function(){
            //     $(".open-modal").click(function(){
            //         var itsupportid = $(this).data('id');
            //         var frameSrc = "/itsupport/"+ itsupportid +"/edit";
            //         $("#updateFrame").attr("src", frameSrc);
            //         $('#exampleModal').modal({ show: true, backdrop: 'static' });
            //     });
            // });
            //
            // $(function(){
            //     $(".open-layui").click(function(){
            //         var itsupportid = $(this).data('id');
            //         var frameSrc = "/itsupport/"+ itsupportid +"/edit";
            //         layer.open({
            //             type: 2,
            //             content: frameSrc, //这里content是一个普通的String
            //             area: ['550px', '600px'],
            //             zIndex: layer.zIndex, //重点1
            //             success: function(layero){
            //                 layer.setTop(layero); //重点2
            //             },
            //             cancel: function(index, layero){
            //                 layer.close(index);
            //                 document.body.style.overflow='';//出现滚动条
            //                 document.removeEventListener("touchmove",mo,false);
            //             },
            //             // end: function () {
            //             //     window.location.reload();
            //             // }
            //
            //         });
            //         document.body.style.overflow='hidden';
            //         document.addEventListener("touchmove",mo,false);//禁止页面滑动
            //     });
            //
            //     $(".open-layui-finish").click(function(){
            //         var itsupportid = $(this).data('id');
            //         var frameSrc = "/itsupport/"+ itsupportid;
            //         layer.open({
            //             type: 2,
            //             content: frameSrc, //这里content是一个普通的String
            //             area: ['550px', '600px'],
            //             zIndex: layer.zIndex, //重点1
            //             success: function(layero){
            //                 layer.setTop(layero); //重点2
            //             },
            //             cancel: function(index, layero){
            //                 layer.close(index);
            //                 document.body.style.overflow='';//出现滚动条
            //                 document.removeEventListener("touchmove",mo,false);
            //             },
            //             // end: function () {
            //             //     window.location.reload();
            //             // }
            //
            //         });
            //         document.body.style.overflow='hidden';
            //         document.addEventListener("touchmove",mo,false);//禁止页面滑动
            //     });
            // });
            //
            // $(document).on('click','.delete-btn',function(){
            //     Swal.fire({
            //         title: '確定取消編號為【' + $(this).data('no') + '】的IT求助項目嗎？?',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: '確認刪除',
            //         cancelButtonText: '取消'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //                 $.ajax({
            //                     type: "DELETE",
            //                     url: "/itsupport/" + $(this).data('id'),
            //                     headers: {
            //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                     },
            //                     success: function (msg) {
            //                         // console.log(msg);
            //                         // alert('範本刪除成功!');
            //                         window.location.reload();
            //                     }
            //                 });
            //             }
            //
            //     })
            //
            // })



        </script>

@endsection
