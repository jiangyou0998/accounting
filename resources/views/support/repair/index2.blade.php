@extends('layouts.app')

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
    <script src="../layui/layui.all.js"></script>
@endsection

@section('content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>維修項目</h2>
        </div>

        <div id="page-wrapper">
            <form class="needs-validation" novalidate="" method="post" action="{{route('repair.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="country">緊急性</label>
                        <select class="custom-select d-block w-100" name="importance" id="importance" required="">
                            <option value="">- 請選擇 -</option>
                            @foreach($importances as $key => $importance)
                                <option value="{{$key}}">{{$importance}} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            請選擇「緊急性」
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state">位置</label>
                        <select class="custom-select d-block w-100" name="locations" id="locations" required="">
                            <option value="">- 請選擇 -</option>
                            @foreach($locations as $locationid => $location)
                                <option value="{{$locationid}}">{{$location}} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            請選擇「位置」
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="state">維修項目</label>
                        <select class="custom-select d-block w-100" name="items" id="items" required="">
                            <option value="">- 請選擇 -</option>
                        </select>
                        <div class="invalid-feedback">
                            請選擇「維修項目」
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="state">求助事宜</label>
                        <select class="custom-select d-block w-100" name="details" id="details" required="">
                            <option value="">- 請選擇 -</option>
                        </select>
                        <div class="invalid-feedback">
                            請選擇「求助事宜」
                        </div>
                    </div>
                </div>
                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <input name="file" id="file" type="file" class="file" data-preview-file-type="text">
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="machine_code">機器號碼#</label>
                                <input type="text" class="form-control" name="machine_code" id="cc-machine_code" placeholder="">

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="cc-expiration">其他資料提供</label>
                                <textarea class="form-control" name="textarea" id="textarea" cols="30"
                                          rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="submit"  data-loading-text="提交中..." disabled>提交</button>
                </div>
            </form>
        </div>
        <!-- /. PAGE WRAPPER  -->
        <hr class="mb-4">
{{--        <button type="button" class="btn btn-primary open-layui" data-id="3">Open modal for @mdo</button>--}}
{{--        <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#exampleModal" data-id="4">Open modal for @fat</button>--}}
{{--        <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#exampleModal" data-id="5">Open modal for @getbootstrap</button>--}}

        @include('support.repair._modal')

        <div class="text-center">
            <h2>未完成處理</h2>
        </div>

        <hr class="mb-4">
        @include('support.repair._unfinished')
        <hr class="mb-4">

        <div class="text-center">
            <h2>最近14天內完成處理之申請</h2>
        </div>

        <hr class="mb-4">
        @include('support.repair._finished')
        <hr class="mb-4">

        <div class="text-center">
            <h2>最近14天內取消之申請</h2>
        </div>

        <hr class="mb-4">
        @include('support.repair._canceled')
        <hr class="mb-4">

        <script type="text/javascript">
            $(document).ready(function () {
                //绑定分类下拉框选项变化事件
                $("#locations").on('change',
                    function () {
                        var locations = $(this).val();
                        $('#items').val('').trigger('change');

                        if (locations == '') {
                            $("#items").empty().append('<option value="" >- 請選擇 -</option>');
                            return;
                        }

                        var items = @json($items);

                        var projectsMap = {};
                        var projectsMap = items[locations];

                        console.log(projectsMap);

                        var option = "";
                        for (var i in projectsMap[0]) {
                            option += '<option value="' + i + '"  >' + projectsMap[0][i] + '</option>';
                        }

                        $("#items").empty().append('<option value="" >- 請選擇 -</option>' + option);


                    });


                $("#items").on('change',
                    function () {
                        var items = $(this).val();
                        $('#details').val('').trigger('change');

                        if (items == '') {
                            $("#details").empty().append('<option value="" >- 請選擇 -</option>');
                            return;
                        }

                        var details = @json($details);

                        var projectsMap = {};
                        var projectsMap = details[items];

                        // console.log(projectsMap);


                        var option = "";
                        for (var i in projectsMap[0]) {
                            option += '<option value="' + i + '"  >' + projectsMap[0][i] + '</option>';
                        }

                        $("#details").empty().append('<option value="" >- 請選擇 -</option>' + option);


                    });

            });

            ;!function(){
                //无需再执行layui.use()方法加载模块，直接使用即可
                var form = layui.form
                    ,layer = layui.layer;

                //…
            }();

            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }else if (form.checkValidity() === true) {
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
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg' , 'mp4', 'mov'],
                overwriteInitial: false,
                showUpload: false,
                showUploadedThumbs: false,
                // dropZoneEnabled: false,
                maxFileSize: 10000,
                maxFilesNum: 10,
                {{--uploadUrl: '{{route('repair.upload')}}',--}}
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

            $(function(){
                $(".open-modal").click(function(){
                    var repairid = $(this).data('id');
                    var frameSrc = "/repair/"+ repairid +"/edit";
                    $("#updateFrame").attr("src", frameSrc);
                    $('#exampleModal').modal({ show: true, backdrop: 'static' });
                });
            });

            $(function(){
                $(".open-layui").click(function(){
                    var repairid = $(this).data('id');
                    var frameSrc = "/repair/"+ repairid +"/edit";
                    layer.open({
                        type: 2,
                        content: frameSrc, //这里content是一个普通的String
                        area: ['550px', '600px'],
                        zIndex: layer.zIndex, //重点1
                        success: function(layero){
                            layer.setTop(layero); //重点2
                        },
                        cancel: function(index, layero){
                            layer.close(index);
                            document.body.style.overflow='';//出现滚动条
                            document.removeEventListener("touchmove",mo,false);
                        },
                        // end: function () {
                        //     window.location.reload();
                        // }

                    });
                    document.body.style.overflow='hidden';
                    document.addEventListener("touchmove",mo,false);//禁止页面滑动
                });

                $(".open-layui-finish").click(function(){
                    var repairid = $(this).data('id');
                    var frameSrc = "/repair/"+ repairid;
                    layer.open({
                        type: 2,
                        content: frameSrc, //这里content是一个普通的String
                        area: ['550px', '600px'],
                        zIndex: layer.zIndex, //重点1
                        success: function(layero){
                            layer.setTop(layero); //重点2
                        },
                        cancel: function(index, layero){
                            layer.close(index);
                            document.body.style.overflow='';//出现滚动条
                            document.removeEventListener("touchmove",mo,false);
                        },
                        // end: function () {
                        //     window.location.reload();
                        // }

                    });
                    document.body.style.overflow='hidden';
                    document.addEventListener("touchmove",mo,false);//禁止页面滑动
                });
            });

            $(document).on('click','.delete-btn',function(){
                Swal.fire({
                    title: '確定取消編號為【' + $(this).data('no') + '】的IT求助項目嗎？?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確認刪除',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "/repair/" + $(this).data('id'),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (msg) {
                                    // console.log(msg);
                                    // alert('範本刪除成功!');
                                    window.location.reload();
                                }
                            });
                        }

                })

            })



        </script>

@endsection
