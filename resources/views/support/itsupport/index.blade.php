@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>IT維修項目</h2>
            {{--        <p class="lead">Below is an example forms built entirely with Bootstrap's forms controls. Each required forms group has a validation state that can be triggered by attempting to submit the forms without completing it.</p>--}}
        </div>
        <div class="row">

{{--            <div class="col-12 order-md-1" style="font-size: 13px">--}}
{{--                <table border="1"  bordercolor="#ccc" cellspacing="0" cellpadding="0" >--}}


{{--                    <tbody><tr>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="10%">日期</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="10%">分店/部門</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="12%">緊急性</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="15%">器材</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="15%">求助事宜</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="10%">機器號碼#</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="13%">其他資料提供</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="12%">上傳文檔(如有)</td>--}}
{{--                        <td align="center" bgcolor="#CCFFFF" width="8%">&nbsp;</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td height="30" align="center">{{\Carbon\Carbon::now()->toDateString()}}</td>--}}
{{--                        <td height="30" align="center">{{Auth::user()->txt_name}}</td>--}}
{{--                        <td height="30" align="center" valign="middle">--}}
{{--                            <select name="sel_Impo" id="sel_Impo" style="width: 95%">--}}
{{--                                <option value="0">請選擇</option>--}}
{{--                                <option value="3">高</option>--}}
{{--                                <option value="4">中</option>--}}
{{--                                <option value="5">低</option>--}}
{{--                            </select>--}}
{{--                        </td>--}}
{{--                        器材--}}
{{--                        <td height="30" align="center" valign="middle">--}}
{{--                            <select id="items" name="items" style="width: 95%">--}}
{{--                                <option value="">請選擇</option>--}}
{{--                                @foreach($items as $itemid => $item)--}}
{{--                                    <option value="{{$itemid}}">{{$item}} </option>--}}
{{--                                @endforeach--}}

{{--                            </select>--}}
{{--                        </td>--}}
{{--                        求助事宜--}}
{{--                        <td height="30" align="center" valign="middle">--}}
{{--                            <select id="details" name="details" style="width: 95%">--}}
{{--                                <option value="">請選擇</option>--}}
{{--                            </select>--}}
{{--                        </td>--}}


{{--                        <td height="30" align="center"><input type="text" name="txt_number" id="txt_number" style="width:90%"></td>--}}


{{--                        <td height="30" align="center">--}}
{{--                            <table width="100%" height="100%">--}}
{{--                                <tbody><tr>--}}
{{--                                    <td width="50%"><textarea name="textarea" id="textarea" style="height: 98%; width: 90%"></textarea></td>--}}
{{--                                </tr>--}}
{{--                                </tbody></table>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <table>--}}
{{--                                <tbody><tr>--}}
{{--                                    <td align="right" bgcolor="#EEEEEE">--}}
{{--                                        <div id="div_file1" style="position: relative">--}}
{{--                                            <input id="uploadfile[]" onchange="upFile('1')" name="uploadfile[]" type="file" style="position:absolute;filter:alpha(opacity=0);  -moz-opacity:0;         /*火狐*/opacity:0;  width:50px;">--}}
{{--                                            <input type="button" id="btnFile1" name="btnFile1" style="width:50px" value="相片1">--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td align="left" bgcolor="#EEEEEE">--}}
{{--                                        <input type="button" id="clear1" name="clear1" onclick="clearFileInputField('1');" value="清除">--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                </tbody></table>--}}
{{--                        </td>--}}
{{--                        <td height="30" align="center">--}}
{{--                            <input name="submit" value="輸入" type="hidden">--}}
{{--                            <input id="insertSubmit" type="submit" value="輸入" style="background-color:green;color:white;">--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </tbody></table>--}}

{{--            </div>--}}


        </div>


        <div id="page-wrapper">
            <form class="needs-validation" novalidate="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>
                </div>

{{--                <div class="mb-3">--}}
{{--                    <label for="username">Username</label>--}}
{{--                    <div class="input-group">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                            <span class="input-group-text">@</span>--}}
{{--                        </div>--}}
{{--                        <input type="text" class="form-control" id="username" placeholder="Username" required="">--}}
{{--                        <div class="invalid-feedback" style="width: 100%;">--}}
{{--                            Your username is required.--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label for="email">Email <span class="text-muted">(Optional)</span></label>--}}
{{--                    <input type="email" class="form-control" id="email" placeholder="you@example.com">--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        Please enter a valid email address for shipping updates.--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label for="address">Address</label>--}}
{{--                    <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        Please enter your shipping address.--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>--}}
{{--                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">--}}
{{--                </div>--}}

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="country">緊急性</label>
                        <select class="custom-select d-block w-100" id="country" required="">
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
                        <select class="custom-select d-block w-100" id="items" required="">
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
                        <select class="custom-select d-block w-100" id="details" required="">
                            <option value="">請選擇</option>
                        </select>
                        <div class="invalid-feedback">
                            請選擇「求助事宜」
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>

                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="paypal">Paypal</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
        <!-- /. PAGE WRAPPER  -->

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

{{--                        @foreach()--}}
{{--                        @endforeach--}}
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

        </script>


@endsection
