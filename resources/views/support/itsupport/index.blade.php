@extends('layouts.app')

@section('js')
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
@endsection

@section('content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>IT維修項目</h2>
        </div>

        <div id="page-wrapper">
            <form class="needs-validation" novalidate="" method="post" action="{{route('itsupport.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="country">緊急性</label>
                        <select class="custom-select d-block w-100" name="importance" id="importance" required="">
                            <option value="">請選擇</option>
                            <option value="3">高</option>
                            <option value="4">中</option>
                            <option value="5">低</option>
                        </select>
                        <div class="invalid-feedback">
                            請選擇「緊急性」
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">器材</label>
                        <select class="custom-select d-block w-100" name="items" id="items" required="">
                            <option value="">請選擇</option>
                            @foreach($items as $itemid => $item)
                                <option value="{{$itemid}}">{{$item}} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            請選擇「器材」
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">求助事宜</label>
                        <select class="custom-select d-block w-100" name="details" id="details" required="">
                            <option value="">請選擇</option>
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
                    <button class="btn btn-primary btn-lg btn-block" type="submit">提交</button>
                </div>
            </form>
        </div>
        <!-- /. PAGE WRAPPER  -->
        <hr class="mb-4">
        <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#exampleModal" data-id="3">Open modal for @mdo</button>
        <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#exampleModal" data-id="4">Open modal for @fat</button>
        <button type="button" class="btn btn-primary open-modal" data-toggle="modal" data-target="#exampleModal" data-id="5">Open modal for @getbootstrap</button>

        @include('support.itsupport._modal')

        <hr class="mb-4">
        @include('support.itsupport._unfinished')
        <hr class="mb-4">

        <script type="text/javascript">
            $(document).ready(function () {
                //绑定分类下拉框选项变化事件
                $("#items").on('change',
                    function () {
                        var items = $(this).val();
                        $('#details').val('').trigger('change');

                        if (items == '') {
                            $("#details").empty().append('<option value="" >- 关联项目 -</option>');
                            return;
                        }

                        var details = @json($details);

                        var projectsMap = {};
                        var projectsMap = details[items];

                        console.log(projectsMap);


                        var option = "";
                        for (var i in projectsMap[0]) {
                            option += '<option value="' + i + '"  >' + projectsMap[0][i] + '</option>';
                        }

                        $("#details").empty().append('<option value="" >請選擇</option>' + option);


                    });

            });

            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
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

            $(function(){
                $(".open-modal").click(function(){
                    var itsupportid = $(this).data('id');
                    var frameSrc = "/itsupport/"+ itsupportid +"/edit";
                    $("#updateFrame").attr("src", frameSrc);
                    $('#exampleModal').modal({ show: true, backdrop: 'static' });
                });
            });



        </script>


@endsection
