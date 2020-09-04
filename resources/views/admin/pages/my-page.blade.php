

<head>
    <META name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <meta http-equiv="Content-Type" content="text/html; charset=big5"/>
        <title>內聯網</title>
        <script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
        <script src="/js/jquery.min.js"></script>
        <script src="/js/parser.js"></script>
        <script type='text/javascript' src="/js/MultipleSelect/multiple-select.js"></script>
        <script type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>
        <link rel="stylesheet" type="text/css" href="/js/MultipleSelect/multiple-select.css">
        <link href="/css/checkbox-style.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            <!--
            .cssTable1 {
                border-collapse: collapse;
                border: 2px solid black;
                position: absolute;
                left: 80px;
                top: 70px;
            }

            .cssTable1 .cssTableField {
                width: 150px;
                border: 2px solid black;
                padding: 10px;
            }

            .cssTable1 .cssTableInput {
                width: 300px;
                border: 2px solid black;
                padding: 10px;
            }

            .cssTable2 {
                border-collapse: collapse;
                border: 2px solid black;
                position: absolute;
                left: 585px;
                top: 70px;
                margin-left: 10px;
                background-color: #697CAF;
                cursor: default;
            }

            .cssTable2 .cssTableField {
                width: 150px;
                border: 2px solid black;
                padding: 10px;
            }

            .cssTable2 .cssTableInput {
                width: 600px;
                border: 2px solid black;
                padding: 5px;
            }

            .cssTable3 {
                border-collapse: collapse;
                border: 2px solid black;
                position: absolute;
                left: 595px;
                top: 70px;
                background-color: #697CAF;
                cursor: default;
                display: none;
            }

            .cssTable3 .cssTableInput {
                width: 600px;
                border: 2px solid black;
                padding: 5px;
            }

            .brand {
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/2.jpg");
                width: 106;
                height: 35;
                text-align: center;
                float: left;
                padding-top: 5px;
            }

            .brand_all {
                float: left;
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/3.jpg");
                width: 106;
                height: 35;
                text-align: center;
                margin: 1px;
                display: none;
                padding-top: 5px;
            }

            .shop {
                float: left;
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/1.jpg");
                width: 106;
                height: 60;
                text-align: center;
                margin: 1px;
                display: none;
                padding-top: 5px;
            }

            .shop_select {
                background: url("/images/6.jpg");
            }

            .cat {
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/2.jpg");
                width: 106px;
                height: 35px;
                text-align: center;
                padding-top: 5px;
            }

            .gp {
                float: left;
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/3.jpg");
                width: 106px;
                height: 35px;
                text-align: center;
                margin: 1px;
                display: none;
                padding-top: 5px;
            }

            .item {
                float: left;
                text-align: center;
                cursor: pointer;
                color: white;
                background: url("/images/1.jpg");
                width: 106px;
                height: 65px;
                text-align: center;
                margin: 1px;
                display: none;
                padding-top: 5px;
            }

            .item_selected {
                background: url("/images/6.jpg");
            }


            #item_list {
                width: 100%;
            }

            .item_list_th {
                text-align: center;
                font-weight: bold;
            }

            .item_list_td {
                width: 150px;
            }

            .item_list_td_1 {
                text-align: center;
            }

            .item_delete {
                width: 25px;
                text-align: center;
            }

            .tab1 {
                position: absolute;
                left: 595px;
                top: 30px;
                width: 100px;
                height: 38px;
                border: 2px solid black;
                text-align: center;
                cursor: pointer;
                padding: 0px;
            }

            .tab2 {
                position: absolute;
                left: 697px;
                top: 30px;
                width: 100px;
                height: 38px;
                border: 2px solid black;
                text-align: center;
                cursor: pointer;
                padding: 0px;
            }

            .active {
                background-color: yellow;
            }

            .cssMenu {
                list-style-type: none;
                padding: 0;
                overflow: hidden;
                background-color: #ECECEC;
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
                background-color: #CCFFFF;
            }

            .ms-drop .container.checkbox-help {
                top: 0px;
                left: 0px;
            }

            .ms-drop span.text {
                margin-left: 25px;
            }

            .checkmark {
                height: 18px;
                width: 18px;
            }

            .container .checkmark:after {
                left: 6px;
                top: 1px;
                width: 5px;
                height: 11px;
            }

            .ms-drop ul > li {
                height: 25px;
            }

            .ms-drop ul > li.multiple label {
                height: 25px;
            }

            -->
        </style>
        <script>
            $(function () {
                $("#email_week").multipleSelect({
                    selectAllText: '所有',
                    allSelected: '每天',
                    countSelected: '已選擇 # 項',
                    minimumCountSelected: 6,
                    multiple: true,
                    multipleWidth: 85,
                    onClose: function () {
                        $("#email_weel_val").val($("#email_week").multipleSelect('getSelects').join(','));
                    }
                });
                $("#email_week").multipleSelect('setSelects', [0,1,2,3,4,5,6]);
            });
            var WdatePickerOpt2 = {
                dateFmt: 'HH:mm',
                isShowClear: false,
                vel: 'time',
                onpicked: function (dp) {

                }
            };
        </script>
        </head>



<div style="width:95%;">
    <h1 id="title" style="position:absolute; left:95px;">修改報告</h1>
    <div class="tab1 active">項目</div>
    <!-- <div class="tab2" >分店</div> -->

    <table class="cssTable1">
        <tr>
            <th class="cssTableField cssImportant">報告名稱</th>
            <td class="cssTableInput"><input type="text" id="report_name"></td>
        </tr>
        <tr>
            <th class="cssTableField cssImportant" valign="top">報表 日期</th>
            <td class="cssTableInput">
                星期:
                <select type="text" id="email_week" style="width:173px;" multiple>
                    <option value="0">星期一</option>
                    <option value="1">星期二</option>
                    <option value="2">星期三</option>
                    <option value="3">星期四</option>
                    <option value="4">星期五</option>
                    <option value="5">星期六</option>
                    <option value="6">星期日</option>
                </select>
                <input type="hidden" id="email_weel_val" value="0,1,2,3,4,5,6"/>
                <br/>
                時間:
                <input type="text" id="email_time" readonly onclick="WdatePicker(WdatePickerOpt2);" style="width:173px;"
                       value="12:00"/>
            </td>
        </tr>
        <tr>
            <th class="cssTableField cssImportant" valign="top">相隔日數</th>
            <td class="cssTableInput"><input type="text" id="num_of_day" oninput="inputChange(this)"
                                             onpropertychange="inputChange(this)" value="1"></td>
        </tr>
        <!--
        <tr>
            <th class="cssTableField cssImportant" valign="top">分開加單</th>
            <td class="cssTableInput">
                <input type="radio" name="separate" value="1" checked id="separate_t">是
                <input type="radio" name="separate" value="0" id="separate_f" style="margin-left:40px">否
            </td>
        </tr>
        <tr>
            <th class="cssTableField cssImportant" valign="top">車牌</th>
            <td class="cssTableInput">
                <input type="radio" name="car" value="1" checked id="car_t">公司車
                <input type="radio" name="car" value="0" id="car_f" style="margin-left:8px">街車
            </td>
        </tr>
        -->
        <tr>
            <th class="cssTableField cssImportant" valign="top">隱藏總數為0的項目</th>
            <td class="cssTableInput">
                <input type="radio" name="hide" value="1" checked id="hide_t">是
                <input type="radio" name="hide" value="0" id="hide_f" style="margin-left:40px">否
            </td>
        </tr>
        <tr>
            <th class="cssTableField cssImportant" valign="top">欄位</th>
            <td class="cssTableInput">
                <input type="radio" name="col" value="1" checked id="main_item">項目
                <input type="radio" name="col" value="0" id="main_shop" style="margin-left:25px">分店
            </td>
        </tr>
        <!--
        <tr>
            <th class="cssTableField cssImportant" valign="top">顯示未確定的項目</th>
            <td class="cssTableInput">
                <input type="radio" name="showNC" value="1" id="showNC_t">是
                <input type="radio" name="showNC" value="0" id="showNC_f" style="margin-left:40px" checked>否
            </td>
        </tr>
        -->
        <tr>
            <th class="cssTableField cssImportant" valign="top">排序</th>
            <td class="cssTableInput"><input style="width:50px;" id="sort" value="1" oninput="inputChange(this)"
                                             onpropertychange="inputChange(this)"></td>
        </tr>
        <!--
        <tr>
            <th class="cssTableField cssImportant" valign="top">分店</th>
            <td class="cssTableInput">
            <div style="height:120px; overflow:scroll; overflow-y:scroll; overflow-x:hidden;" id="shop_message">
            </div>
            </td>
        </tr>
        -->
        <tr>
            <th class="cssTableField cssImportant" valign="top">項目</th>
            <td class="cssTableInput">
                <div style="height:362px; overflow:scroll; overflow-y:scroll; overflow-x:hidden;">
                    <table id="item_list">

                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <!-- <img src="./images/Confirm2.jpg" onclick="console.log(reportInfo());" style="cursor:pointer"> -->
                <img src="./images/Confirm2.jpg" onclick="submit()" style="cursor:pointer">
                <img src="./images/Return.jpg" onclick="document.location='/CMS_order_c_check_list.php';"
                     style="cursor:pointer">
            </td>
        </tr>
    </table>

    <table class="cssTable2">
        <tr style="color:white;">
            <th class="cssTableField">按貨品編號查找</th>
            <td class="cssTableInput" valign="middle" style="width:300px;">
                <div>
                    <input type="text" id="search_no" style="width:150px;"
                           onkeypress='search_code($("#search_no").val(), event);'>
                    <button onclick='search_code($("#search_no").val());'>查找</button>
                </div>
            </td>
        </tr>
        <tr>
            <td class="cssTableInput" valign="top" colspan="2">
                <table>
                    <tr>
                        <td class="cat" id="3" background="/images/2.jpg" valign="top">
                            <div>
                                麵包部                                </div>
                        </td>
                        <td class="cat" id="2" background="/images/2.jpg" valign="top">
                            <div>
                                西餅部                                </div>
                        </td>
                        <td class="cat" id="1" background="/images/2.jpg" valign="top">
                            <div>
                                廚務部                                </div>
                        </td>
                        <td class="cat" id="5" background="/images/2.jpg" valign="top">
                            <div>
                                轉手貨                                </div>
                        </td>
                        <td class="cat" id="6" background="/images/2.jpg" valign="top">
                            <div>
                                時節產品                                </div>
                        </td>
                    </tr><tr>                                            </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="cssTableInput" style="height:200px;" valign="top" colspan="2">
                <div id="150" class="gp cat_3">生包</div>
                <div id="151" class="gp cat_3">生包-方包/家庭裝</div>
                <div id="152" class="gp cat_3">熟包-包仔</div>
                <div id="153" class="gp cat_3">熟包-方包</div>
                <div id="154" class="gp cat_3">熟包-家庭裝</div>
                <div id="155" class="gp cat_3">撻皮/什項</div>
                <div id="156" class="gp cat_3">包-餡料</div>
                <div id="157" class="gp cat_3">包-到會</div>
                <div id="158" class="gp cat_2">鮮餅-門市蛋糕</div>
                <div id="159" class="gp cat_2">鮮餅-卷類</div>
                <div id="160" class="gp cat_2">鮮餅-切件</div>
                <div id="161" class="gp cat_2">鮮餅-甜品</div>
                <div id="162" class="gp cat_2">鮮餅-訂餅蛋糕</div>
                <div id="163" class="gp cat_2">常溫蛋糕</div>
                <div id="164" class="gp cat_2">餅-到會</div>
                <div id="165" class="gp cat_1">凍肉</div>
                <div id="166" class="gp cat_1">廚-汁醬/配料</div>
                <div id="167" class="gp cat_1">廚-點心/餡料</div>
                <div id="168" class="gp cat_1">廚-快餐</div>
                <div id="169" class="gp cat_1">廚-飲品</div>
                <div id="170" class="gp cat_1">廚-到會</div>
                <div id="171" class="gp cat_5">食材-凍貨</div>
                <div id="172" class="gp cat_5">食材-乾貨</div>
                <div id="173" class="gp cat_5">OEM</div>
                <div id="174" class="gp cat_5">包裝用品</div>
                <div id="175" class="gp cat_5">清潔用品</div>
                <div id="176" class="gp cat_5">消耗用品</div>
                <div id="177" class="gp cat_5">器皿用具</div>
                <div id="178" class="gp cat_5">印刷文具</div>
                <div id="179" class="gp cat_5">公司制服</div>
                <div id="180" class="gp cat_2">固定柯打</div>
                <div id="181" class="gp cat_6">月餅</div>
            </td>
        </tr>
        <tr>
            <td class="cssTableInput" valign="top" colspan="2">
                <div style="float:left; height:20px; width:30px; background-color:#00356B"></div>
                <span style="float:left; color:white">可選擇</span>
                <div style="float:left; height:20px; width:30px; margin-left:50px; background-color:#717171"></div>
                <span style="color:white">已選擇</span><br><br>

                <div style="height:369px; overflow:scroll; overflow-y:scroll; overflow-x:hidden;">
                    <div id="item_842"
                         class="item gp_150">咸麵粒<input type="hidden"
                                                       id="code_1000001"
                                                       value="1000001"
                                                       class="no"></div>
                    <div id="item_843"
                         class="item gp_150">甜麵粒<input type="hidden"
                                                       id="code_1000002"
                                                       value="1000002"
                                                       class="no"></div>
                    <div id="item_844"
                         class="item gp_150">提子麥麵粒<input type="hidden"
                                                         id="code_1000003"
                                                         value="1000003"
                                                         class="no"></div>
                    <div id="item_845"
                         class="item gp_150">(M)咸餐<input type="hidden"
                                                         id="code_1001001"
                                                         value="1001001"
                                                         class="no"></div>
                    <div id="item_846"
                         class="item gp_150">豬仔<input type="hidden"
                                                      id="code_1001002"
                                                      value="1001002"
                                                      class="no"></div>
                    <div id="item_847"
                         class="item gp_150">咸卷<input type="hidden"
                                                      id="code_1001003"
                                                      value="1001003"
                                                      class="no"></div>
                    <div id="item_848"
                         class="item gp_150">軟心芝士<input type="hidden"
                                                        id="code_1001004"
                                                        value="1001004"
                                                        class="no"></div>
                    <div id="item_849"
                         class="item gp_150">黃金芝士<input type="hidden"
                                                        id="code_1001005"
                                                        value="1001005"
                                                        class="no"></div>
                    <div id="item_850"
                         class="item gp_150">薄餅底<input type="hidden"
                                                       id="code_1001006"
                                                       value="1001006"
                                                       class="no"></div>
                    <div id="item_851"
                         class="item gp_150">(M)甜餐<input type="hidden"
                                                         id="code_1002001"
                                                         value="1002001"
                                                         class="no"></div>
                    <div id="item_852"
                         class="item gp_150">熱狗<input type="hidden"
                                                      id="code_1002002"
                                                      value="1002002"
                                                      class="no"></div>
                    <div id="item_853"
                         class="item gp_150">芝士條<input type="hidden"
                                                       id="code_1002003"
                                                       value="1002003"
                                                       class="no"></div>
                    <div id="item_854"
                         class="item gp_150">雞尾<input type="hidden"
                                                      id="code_1002004"
                                                      value="1002004"
                                                      class="no"></div>
                    <div id="item_855"
                         class="item gp_150">叉燒包<input type="hidden"
                                                       id="code_1002005"
                                                       value="1002005"
                                                       class="no"></div>
                    <div id="item_856"
                         class="item gp_150">吞拿魚<input type="hidden"
                                                       id="code_1002006"
                                                       value="1002006"
                                                       class="no"></div>
                    <div id="item_857"
                         class="item gp_150">腸仔包<input type="hidden"
                                                       id="code_1002007"
                                                       value="1002007"
                                                       class="no"></div>
                    <div id="item_858"
                         class="item gp_150">紅豆菠蘿<input type="hidden"
                                                        id="code_1002008"
                                                        value="1002008"
                                                        class="no"></div>
                    <div id="item_859"
                         class="item gp_150">椰絲菠蘿<input type="hidden"
                                                        id="code_1002009"
                                                        value="1002009"
                                                        class="no"></div>
                    <div id="item_860"
                         class="item gp_150">大麥<input type="hidden"
                                                      id="code_1003001"
                                                      value="1003001"
                                                      class="no"></div>
                    <div id="item_861"
                         class="item gp_150">提子合桃<input type="hidden"
                                                        id="code_1003002"
                                                        value="1003002"
                                                        class="no"></div>
                    <div id="item_862"
                         class="item gp_150">丹麥條<input type="hidden"
                                                       id="code_1004001"
                                                       value="1004001"
                                                       class="no"></div>
                    <div id="item_863"
                         class="item gp_150">牛角酥<input type="hidden"
                                                       id="code_1004002"
                                                       value="1004002"
                                                       class="no"></div>
                    <div id="item_1307"
                         class="item gp_150">洋蔥火腿鹹芝士條麵<input type="hidden"
                                                             id="code_1001007"
                                                             value="1001007"
                                                             class="no"></div>
                    <div id="item_864"
                         class="item gp_151">湯種方包麵<input type="hidden"
                                                         id="code_1005001"
                                                         value="1005001"
                                                         class="no"></div>
                    <div id="item_865"
                         class="item gp_151">湯芝士方包麵<input type="hidden"
                                                          id="code_1005002"
                                                          value="1005002"
                                                          class="no"></div>
                    <div id="item_866"
                         class="item gp_151">湯提子方包麵<input type="hidden"
                                                          id="code_1005003"
                                                          value="1005003"
                                                          class="no"></div>
                    <div id="item_867"
                         class="item gp_151">湯黑芝麻方包麵<input type="hidden"
                                                           id="code_1005004"
                                                           value="1005004"
                                                           class="no"></div>
                    <div id="item_868"
                         class="item gp_151">湯綠荼紅豆方包麵<input type="hidden"
                                                            id="code_1005005"
                                                            value="1005005"
                                                            class="no"></div>
                    <div id="item_869"
                         class="item gp_151">奶油立方麵<input type="hidden"
                                                         id="code_1006001"
                                                         value="1006001"
                                                         class="no"></div>
                    <div id="item_870"
                         class="item gp_151">焦糖立方麵<input type="hidden"
                                                         id="code_1006002"
                                                         value="1006002"
                                                         class="no"></div>
                    <div id="item_871"
                         class="item gp_151">朱古力立方麵<input type="hidden"
                                                          id="code_1006003"
                                                          value="1006003"
                                                          class="no"></div>
                    <div id="item_872"
                         class="item gp_151">雞尾檳<input type="hidden"
                                                       id="code_1007001"
                                                       value="1007001"
                                                       class="no"></div>
                    <div id="item_873"
                         class="item gp_151">忌廉紅豆檳<input type="hidden"
                                                         id="code_1007002"
                                                         value="1007002"
                                                         class="no"></div>
                    <div id="item_874"
                         class="item gp_151">湯種麵糰<input type="hidden"
                                                        id="code_1007003"
                                                        value="1007003"
                                                        class="no"></div>
                    <div id="item_875"
                         class="item gp_151">提子燕麥<input type="hidden"
                                                        id="code_1007004"
                                                        value="1007004"
                                                        class="no"></div>
                    <div id="item_876"
                         class="item gp_151">紅豆忌廉<input type="hidden"
                                                        id="code_1007005"
                                                        value="1007005"
                                                        class="no"></div>
                    <div id="item_877"
                         class="item gp_151">黑豆核桃包<input type="hidden"
                                                         id="code_1007006"
                                                         value="1007006"
                                                         class="no"></div>
                    <div id="item_878"
                         class="item gp_151">裸麥雜糧包<input type="hidden"
                                                         id="code_1007007"
                                                         value="1007007"
                                                         class="no"></div>
                    <div id="item_879"
                         class="item gp_151">裸麥提子核桃<input type="hidden"
                                                          id="code_1007008"
                                                          value="1007008"
                                                          class="no"></div>
                    <div id="item_880"
                         class="item gp_151">日式雜豆海棉包(生)<input type="hidden"
                                                              id="code_1007009"
                                                              value="1007009"
                                                              class="no"></div>
                    <div id="item_881"
                         class="item gp_151">日式雜果海棉包(生)<input type="hidden"
                                                              id="code_1007010"
                                                              value="1007010"
                                                              class="no"></div>
                    <div id="item_882"
                         class="item gp_151">日式核桃海棉包(生)<input type="hidden"
                                                              id="code_1007011"
                                                              value="1007011"
                                                              class="no"></div>
                    <div id="item_883"
                         class="item gp_152">菠蘿包<input type="hidden"
                                                       id="code_1100001"
                                                       value="1100001"
                                                       class="no"></div>
                    <div id="item_884"
                         class="item gp_152">雞尾包<input type="hidden"
                                                       id="code_1100002"
                                                       value="1100002"
                                                       class="no"></div>
                    <div id="item_885"
                         class="item gp_152">叉燒包<input type="hidden"
                                                       id="code_1100003"
                                                       value="1100003"
                                                       class="no"></div>
                    <div id="item_886"
                         class="item gp_152">腸仔包<input type="hidden"
                                                       id="code_1100004"
                                                       value="1100004"
                                                       class="no"></div>
                    <div id="item_887"
                         class="item gp_152">吞拿魚包<input type="hidden"
                                                        id="code_1100005"
                                                        value="1100005"
                                                        class="no"></div>
                    <div id="item_888"
                         class="item gp_152">咖喱牛肉包<input type="hidden"
                                                         id="code_1100006"
                                                         value="1100006"
                                                         class="no"></div>
                    <div id="item_889"
                         class="item gp_152">芝士條<input type="hidden"
                                                       id="code_1100007"
                                                       value="1100007"
                                                       class="no"></div>
                    <div id="item_890"
                         class="item gp_152">軟心芝士<input type="hidden"
                                                        id="code_1100008"
                                                        value="1100008"
                                                        class="no"></div>
                    <div id="item_891"
                         class="item gp_152">紫薯包<input type="hidden"
                                                       id="code_1100009"
                                                       value="1100009"
                                                       class="no"></div>
                    <div id="item_892"
                         class="item gp_152">芝士孖住上<input type="hidden"
                                                         id="code_1100010"
                                                         value="1100010"
                                                         class="no"></div>
                    <div id="item_893"
                         class="item gp_152">香芝焗煙肉<input type="hidden"
                                                         id="code_1100011"
                                                         value="1100011"
                                                         class="no"></div>
                    <div id="item_894"
                         class="item gp_152">提子合桃<input type="hidden"
                                                        id="code_1100012"
                                                        value="1100012"
                                                        class="no"></div>
                    <div id="item_895"
                         class="item gp_152">大麥包<input type="hidden"
                                                       id="code_1100013"
                                                       value="1100013"
                                                       class="no"></div>
                    <div id="item_896"
                         class="item gp_152">熱狗<input type="hidden"
                                                      id="code_1100014"
                                                      value="1100014"
                                                      class="no"></div>
                    <div id="item_897"
                         class="item gp_152">芝麻咸卷<input type="hidden"
                                                        id="code_1100015"
                                                        value="1100015"
                                                        class="no"></div>
                    <div id="item_898"
                         class="item gp_152">丹麥條<input type="hidden"
                                                       id="code_1100016"
                                                       value="1100016"
                                                       class="no"></div>
                    <div id="item_899"
                         class="item gp_152">紅豆菠蘿包<input type="hidden"
                                                         id="code_1100017"
                                                         value="1100017"
                                                         class="no"></div>
                    <div id="item_900"
                         class="item gp_152">椰絲菠蘿包<input type="hidden"
                                                         id="code_1100018"
                                                         value="1100018"
                                                         class="no"></div>
                    <div id="item_901"
                         class="item gp_152">提子菠蘿包<input type="hidden"
                                                         id="code_1100019"
                                                         value="1100019"
                                                         class="no"></div>
                    <div id="item_902"
                         class="item gp_152">餐肉包<input type="hidden"
                                                       id="code_1100020"
                                                       value="1100020"
                                                       class="no"></div>
                    <div id="item_903"
                         class="item gp_152">軟心芝士火腿卷<input type="hidden"
                                                           id="code_1100021"
                                                           value="1100021"
                                                           class="no"></div>
                    <div id="item_904"
                         class="item gp_152">芝士脆皮腸包<input type="hidden"
                                                          id="code_1100022"
                                                          value="1100022"
                                                          class="no"></div>
                    <div id="item_905"
                         class="item gp_153">咸方包<input type="hidden"
                                                       id="code_1102001"
                                                       value="1102001"
                                                       class="no"></div>
                    <div id="item_906"
                         class="item gp_153">全麥方包<input type="hidden"
                                                        id="code_1102002"
                                                        value="1102002"
                                                        class="no"></div>
                    <div id="item_907"
                         class="item gp_153">英式方包<input type="hidden"
                                                        id="code_1102003"
                                                        value="1102003"
                                                        class="no"></div>
                    <div id="item_908"
                         class="item gp_153">咸方包(厚切)<input type="hidden"
                                                           id="code_1102010"
                                                           value="1102010"
                                                           class="no"></div>
                    <div id="item_1375"
                         class="item gp_153">湯種方包(薄切)<input type="hidden"
                                                            id="code_1102011"
                                                            value="1102011"
                                                            class="no"></div>
                    <div id="item_909"
                         class="item gp_153">湯種方包<input type="hidden"
                                                        id="code_1102005"
                                                        value="1102005"
                                                        class="no"></div>
                    <div id="item_910"
                         class="item gp_153">湯種芝士方包<input type="hidden"
                                                          id="code_1102006"
                                                          value="1102006"
                                                          class="no"></div>
                    <div id="item_911"
                         class="item gp_153">湯種葡萄方包(細)<input type="hidden"
                                                             id="code_1102007"
                                                             value="1102007"
                                                             class="no"></div>
                    <div id="item_912"
                         class="item gp_153">湯種黑芝麻方包<input type="hidden"
                                                           id="code_1102008"
                                                           value="1102008"
                                                           class="no"></div>
                    <div id="item_913"
                         class="item gp_153">湯種綠茶紅豆方包<input type="hidden"
                                                            id="code_1102009"
                                                            value="1102009"
                                                            class="no"></div>
                    <div id="item_914"
                         class="item gp_154">奶油反卷方包<input type="hidden"
                                                          id="code_1103001"
                                                          value="1103001"
                                                          class="no"></div>
                    <div id="item_915"
                         class="item gp_154">焦糖反卷方包<input type="hidden"
                                                          id="code_1103002"
                                                          value="1103002"
                                                          class="no"></div>
                    <div id="item_916"
                         class="item gp_154">朱古力反卷方包<input type="hidden"
                                                           id="code_1103003"
                                                           value="1103003"
                                                           class="no"></div>
                    <div id="item_917"
                         class="item gp_154">牛油排包<input type="hidden"
                                                        id="code_1104001"
                                                        value="1104001"
                                                        class="no"></div>
                    <div id="item_918"
                         class="item gp_154">藍莓合桃<input type="hidden"
                                                        id="code_1104002"
                                                        value="1104002"
                                                        class="no"></div>
                    <div id="item_919"
                         class="item gp_154">麥香芝士<input type="hidden"
                                                        id="code_1104003"
                                                        value="1104003"
                                                        class="no"></div>
                    <div id="item_920"
                         class="item gp_154">提子燕麥<input type="hidden"
                                                        id="code_1104004"
                                                        value="1104004"
                                                        class="no"></div>
                    <div id="item_921"
                         class="item gp_154">紅豆忌廉<input type="hidden"
                                                        id="code_1104005"
                                                        value="1104005"
                                                        class="no"></div>
                    <div id="item_922"
                         class="item gp_154">黑豆核桃包<input type="hidden"
                                                         id="code_1104006"
                                                         value="1104006"
                                                         class="no"></div>
                    <div id="item_923"
                         class="item gp_154">裸麥雜糧包<input type="hidden"
                                                         id="code_1104007"
                                                         value="1104007"
                                                         class="no"></div>
                    <div id="item_924"
                         class="item gp_154">裸麥提子核桃<input type="hidden"
                                                          id="code_1104008"
                                                          value="1104008"
                                                          class="no"></div>
                    <div id="item_925"
                         class="item gp_154">日式雜豆海棉包<input type="hidden"
                                                           id="code_1104009"
                                                           value="1104009"
                                                           class="no"></div>
                    <div id="item_926"
                         class="item gp_154">日式雜果海棉包<input type="hidden"
                                                           id="code_1104010"
                                                           value="1104010"
                                                           class="no"></div>
                    <div id="item_927"
                         class="item gp_154">日式核桃海棉包<input type="hidden"
                                                           id="code_1104011"
                                                           value="1104011"
                                                           class="no"></div>
                    <div id="item_928"
                         class="item gp_155">脆脆豬<input type="hidden"
                                                       id="code_1105001"
                                                       value="1105001"
                                                       class="no"></div>
                    <div id="item_929"
                         class="item gp_155">熟雞批(24)<input type="hidden"
                                                           id="code_1105002"
                                                           value="1105002"
                                                           class="no"></div>
                    <div id="item_930"
                         class="item gp_155">酥皮(240)<input type="hidden"
                                                           id="code_1200001"
                                                           value="1200001"
                                                           class="no"></div>
                    <div id="item_931"
                         class="item gp_155">牛油皮(110)<input type="hidden"
                                                            id="code_1200002"
                                                            value="1200002"
                                                            class="no"></div>
                    <div id="item_932"
                         class="item gp_155">雞批(24)<input type="hidden"
                                                          id="code_1200003"
                                                          value="1200003"
                                                          class="no"></div>
                    <div id="item_933"
                         class="item gp_155">豆沙燒餅(30)<input type="hidden"
                                                            id="code_1200004"
                                                            value="1200004"
                                                            class="no"></div>
                    <div id="item_934"
                         class="item gp_156">菠蘿皮(30p)<input type="hidden"
                                                            id="code_1201001"
                                                            value="1201001"
                                                            class="no"></div>
                    <div id="item_935"
                         class="item gp_156">蒜茸牛油(3磅)<input type="hidden"
                                                            id="code_1201002"
                                                            value="1201002"
                                                            class="no"></div>
                    <div id="item_936"
                         class="item gp_156">墨西哥油(12磅)<input type="hidden"
                                                             id="code_1201003"
                                                             value="1201003"
                                                             class="no"></div>
                    <div id="item_937"
                         class="item gp_156">鮮奶球油(15磅)<input type="hidden"
                                                             id="code_1201004"
                                                             value="1201004"
                                                             class="no"></div>
                    <div id="item_938"
                         class="item gp_156">牛油粒(3磅)<input type="hidden"
                                                           id="code_1201005"
                                                           value="1201005"
                                                           class="no"></div>
                    <div id="item_939"
                         class="item gp_156">奶油(3磅)<input type="hidden"
                                                          id="code_1201006"
                                                          value="1201006"
                                                          class="no"></div>
                    <div id="item_940"
                         class="item gp_156">雞尾餡(7.5磅)<input type="hidden"
                                                             id="code_1201007"
                                                             value="1201007"
                                                             class="no"></div>
                    <div id="item_941"
                         class="item gp_156">吞拿魚餡(3磅)<input type="hidden"
                                                            id="code_1201008"
                                                            value="1201008"
                                                            class="no"></div>
                    <div id="item_942"
                         class="item gp_156">吉士餡(3磅)<input type="hidden"
                                                           id="code_1201009"
                                                           value="1201009"
                                                           class="no"></div>
                    <div id="item_943"
                         class="item gp_156">紫薯餡(3磅)<input type="hidden"
                                                           id="code_1201010"
                                                           value="1201010"
                                                           class="no"></div>
                    <div id="item_944"
                         class="item gp_156">蛋漿(10lb)<input type="hidden"
                                                            id="code_1201011"
                                                            value="1201011"
                                                            class="no"></div>
                    <div id="item_945"
                         class="item gp_156">特濃牛乳蛋漿(8lb)<input type="hidden"
                                                               id="code_1201012"
                                                               value="1201012"
                                                               class="no"></div>
                    <div id="item_946"
                         class="item gp_157">迷你叉燒批(24件)<input type="hidden"
                                                              id="code_1202001"
                                                              value="1202001"
                                                              class="no"></div>
                    <div id="item_947"
                         class="item gp_158">6吋 芒果<input type="hidden"
                                                         id="code_2000001"
                                                         value="2000001"
                                                         class="no"></div>
                    <div id="item_948"
                         class="item gp_158">6吋 朱古力<input type="hidden"
                                                          id="code_2000002"
                                                          value="2000002"
                                                          class="no"></div>
                    <div id="item_949"
                         class="item gp_158">6吋 雜果<input type="hidden"
                                                         id="code_2000003"
                                                         value="2000003"
                                                         class="no"></div>
                    <div id="item_950"
                         class="item gp_158">6吋 黑森林<input type="hidden"
                                                          id="code_2000004"
                                                          value="2000004"
                                                          class="no"></div>
                    <div id="item_951"
                         class="item gp_158">6吋 栗子<input type="hidden"
                                                         id="code_2000005"
                                                         value="2000005"
                                                         class="no"></div>
                    <div id="item_952"
                         class="item gp_158">4吋 椰子<input type="hidden"
                                                         id="code_2001001"
                                                         value="2001001"
                                                         class="no"></div>
                    <div id="item_953"
                         class="item gp_158">4吋 朱古力<input type="hidden"
                                                          id="code_2001002"
                                                          value="2001002"
                                                          class="no"></div>
                    <div id="item_954"
                         class="item gp_158">4吋 芒果<input type="hidden"
                                                         id="code_2001003"
                                                         value="2001003"
                                                         class="no"></div>
                    <div id="item_955"
                         class="item gp_158">4吋 士多啤梨<input type="hidden"
                                                           id="code_2001004"
                                                           value="2001004"
                                                           class="no"></div>
                    <div id="item_956"
                         class="item gp_159">蛋味瑞士卷(3)<input type="hidden"
                                                            id="code_2003001"
                                                            value="2003001"
                                                            class="no"></div>
                    <div id="item_957"
                         class="item gp_159">北海道3.6牛乳卷<input type="hidden"
                                                             id="code_2003002"
                                                             value="2003002"
                                                             class="no"></div>
                    <div id="item_958"
                         class="item gp_159">抹茶紅豆牛乳卷<input type="hidden"
                                                           id="code_2003003"
                                                           value="2003003"
                                                           class="no"></div>
                    <div id="item_959"
                         class="item gp_159">青森縣蘋果牛乳卷<input type="hidden"
                                                            id="code_2003004"
                                                            value="2003004"
                                                            class="no"></div>
                    <div id="item_960"
                         class="item gp_159">紫薯卷<input type="hidden"
                                                       id="code_2003005"
                                                       value="2003005"
                                                       class="no"></div>
                    <div id="item_961"
                         class="item gp_180">朱古力瑞士餅<input type="hidden"
                                                          id="code_2004001"
                                                          value="2004001"
                                                          class="no"></div>
                    <div id="item_962"
                         class="item gp_180">石板街<input type="hidden"
                                                       id="code_2004002"
                                                       value="2004002"
                                                       class="no"></div>
                    <div id="item_963"
                         class="item gp_160">蜜瓜凍餅<input type="hidden"
                                                        id="code_2004003"
                                                        value="2004003"
                                                        class="no"></div>
                    <div id="item_964"
                         class="item gp_160">芒果朱古力凍餅<input type="hidden"
                                                           id="code_2004004"
                                                           value="2004004"
                                                           class="no"></div>
                    <div id="item_965"
                         class="item gp_160">草莓凍餅<input type="hidden"
                                                        id="code_2004005"
                                                        value="2004005"
                                                        class="no"></div>
                    <div id="item_966"
                         class="item gp_160">意大利芝士凍餅<input type="hidden"
                                                           id="code_2004006"
                                                           value="2004006"
                                                           class="no"></div>
                    <div id="item_967"
                         class="item gp_160">Oreo凍餅<input type="hidden"
                                                          id="code_2004007"
                                                          value="2004007"
                                                          class="no"></div>
                    <div id="item_968"
                         class="item gp_161">半熟芝士撻(28)<input type="hidden"
                                                             id="code_2005001"
                                                             value="2005001"
                                                             class="no"></div>
                    <div id="item_969"
                         class="item gp_161">特濃芒果布甸杯<input type="hidden"
                                                           id="code_2005002"
                                                           value="2005002"
                                                           class="no"></div>
                    <div id="item_970"
                         class="item gp_180">芝士蛋糕<input type="hidden"
                                                        id="code_2005003"
                                                        value="2005003"
                                                        class="no"></div>
                    <div id="item_971"
                         class="item gp_162">生日牌<input type="hidden"
                                                       id="code_2006001"
                                                       value="2006001"
                                                       class="no"></div>
                    <div id="item_972"
                         class="item gp_162">訂餅-4吋 蛋糕<input type="hidden"
                                                            id="code_2006002"
                                                            value="2006002"
                                                            class="no"></div>
                    <div id="item_973"
                         class="item gp_162">訂餅-6吋 蛋糕<input type="hidden"
                                                            id="code_2006003"
                                                            value="2006003"
                                                            class="no"></div>
                    <div id="item_974"
                         class="item gp_162">訂餅-2磅 蛋糕<input type="hidden"
                                                            id="code_2006004"
                                                            value="2006004"
                                                            class="no"></div>
                    <div id="item_975"
                         class="item gp_162">訂餅-3磅 蛋糕<input type="hidden"
                                                            id="code_2006005"
                                                            value="2006005"
                                                            class="no"></div>
                    <div id="item_976"
                         class="item gp_162">訂餅-4磅 蛋糕<input type="hidden"
                                                            id="code_2006006"
                                                            value="2006006"
                                                            class="no"></div>
                    <div id="item_977"
                         class="item gp_162">訂餅-5磅 蛋糕<input type="hidden"
                                                            id="code_2006007"
                                                            value="2006007"
                                                            class="no"></div>
                    <div id="item_978"
                         class="item gp_162">訂餅-6磅 蛋糕<input type="hidden"
                                                            id="code_2006008"
                                                            value="2006008"
                                                            class="no"></div>
                    <div id="item_979"
                         class="item gp_162">訂餅-7磅 蛋糕<input type="hidden"
                                                            id="code_2006009"
                                                            value="2006009"
                                                            class="no"></div>
                    <div id="item_980"
                         class="item gp_162">訂餅-8磅 蛋糕<input type="hidden"
                                                            id="code_2006010"
                                                            value="2006010"
                                                            class="no"></div>
                    <div id="item_981"
                         class="item gp_162">訂餅-9磅 蛋糕<input type="hidden"
                                                            id="code_2006011"
                                                            value="2006011"
                                                            class="no"></div>
                    <div id="item_982"
                         class="item gp_162">訂餅-10磅 蛋糕<input type="hidden"
                                                             id="code_2006012"
                                                             value="2006012"
                                                             class="no"></div>
                    <div id="item_983"
                         class="item gp_162">清蛋糕 ($80/磅)<input type="hidden"
                                                               id="code_2006013"
                                                               value="2006013"
                                                               class="no"></div>
                    <div id="item_984"
                         class="item gp_162">訂餅-美圖蛋糕(2磅)<input type="hidden"
                                                               id="code_2006014"
                                                               value="2006014"
                                                               class="no"></div>
                    <div id="item_985"
                         class="item gp_163">蛋糕仔<input type="hidden"
                                                       id="code_2100001"
                                                       value="2100001"
                                                       class="no"></div>
                    <div id="item_986"
                         class="item gp_163">牛奶迷你蛋糕(50)<input type="hidden"
                                                              id="code_2100002"
                                                              value="2100002"
                                                              class="no"></div>
                    <div id="item_987"
                         class="item gp_163">牛油切片<input type="hidden"
                                                        id="code_2100003"
                                                        value="2100003"
                                                        class="no"></div>
                    <div id="item_988"
                         class="item gp_163">合桃切片<input type="hidden"
                                                        id="code_2100004"
                                                        value="2100004"
                                                        class="no"></div>
                    <div id="item_989"
                         class="item gp_163">柚子切片<input type="hidden"
                                                        id="code_2100005"
                                                        value="2100005"
                                                        class="no"></div>
                    <div id="item_990"
                         class="item gp_163">牛油曲奇(10)<input type="hidden"
                                                            id="code_2100006"
                                                            value="2100006"
                                                            class="no"></div>
                    <div id="item_991"
                         class="item gp_163">紙包蛋糕-蜂蜜味<input type="hidden"
                                                            id="code_2101001"
                                                            value="2101001"
                                                            class="no"></div>
                    <div id="item_992"
                         class="item gp_163">湯種蛋糕-原味<input type="hidden"
                                                           id="code_2101002"
                                                           value="2101002"
                                                           class="no"></div>
                    <div id="item_993"
                         class="item gp_163">湯種蛋糕-朱古力<input type="hidden"
                                                            id="code_2101003"
                                                            value="2101003"
                                                            class="no"></div>
                    <div id="item_994"
                         class="item gp_163">蜂蜜戚風蛋糕<input type="hidden"
                                                          id="code_2101004"
                                                          value="2101004"
                                                          class="no"></div>
                    <div id="item_995"
                         class="item gp_164">香芒布甸(3磅)<input type="hidden"
                                                            id="code_2200001"
                                                            value="2200001"
                                                            class="no"></div>
                    <div id="item_996"
                         class="item gp_164">迷你雜果撻(24件)<input type="hidden"
                                                              id="code_2200002"
                                                              value="2200002"
                                                              class="no"></div>
                    <div id="item_997"
                         class="item gp_164">意大利芝士餅(24小件)<input type="hidden"
                                                                id="code_2200003"
                                                                value="2200003"
                                                                class="no"></div>
                    <div id="item_998"
                         class="item gp_165">排骨(10磅)<input type="hidden"
                                                           id="code_3000001"
                                                           value="3000001"
                                                           class="no"></div>
                    <div id="item_999"
                         class="item gp_165">雞肉(10磅)<input type="hidden"
                                                           id="code_3000002"
                                                           value="3000002"
                                                           class="no"></div>
                    <div id="item_1000"
                         class="item gp_165">鳳爪(5磅)<input type="hidden"
                                                          id="code_3000003"
                                                          value="3000003"
                                                          class="no"></div>
                    <div id="item_1001"
                         class="item gp_165">雞中翼(5磅)<input type="hidden"
                                                           id="code_3000004"
                                                           value="3000004"
                                                           class="no"></div>
                    <div id="item_1002"
                         class="item gp_165">雞粒(5磅)<input type="hidden"
                                                          id="code_3000005"
                                                          value="3000005"
                                                          class="no"></div>
                    <div id="item_1003"
                         class="item gp_165">原味雞扒(5磅)<input type="hidden"
                                                            id="code_3000006"
                                                            value="3000006"
                                                            class="no"></div>
                    <div id="item_1004"
                         class="item gp_165">雞髀扒(5磅)<input type="hidden"
                                                           id="code_3000007"
                                                           value="3000007"
                                                           class="no"></div>
                    <div id="item_1005"
                         class="item gp_165">蒸肉餅(5磅)<input type="hidden"
                                                           id="code_3000008"
                                                           value="3000008"
                                                           class="no"></div>
                    <div id="item_1006"
                         class="item gp_165">肉片(5磅)<input type="hidden"
                                                          id="code_3000009"
                                                          value="3000009"
                                                          class="no"></div>
                    <div id="item_1007"
                         class="item gp_165">肉絲(5磅)<input type="hidden"
                                                          id="code_3000010"
                                                          value="3000010"
                                                          class="no"></div>
                    <div id="item_1008"
                         class="item gp_165">原味豬扒(5磅)<input type="hidden"
                                                            id="code_3000011"
                                                            value="3000011"
                                                            class="no"></div>
                    <div id="item_1009"
                         class="item gp_165">香茅豬扒(5磅)<input type="hidden"
                                                            id="code_3000012"
                                                            value="3000012"
                                                            class="no"></div>
                    <div id="item_1010"
                         class="item gp_165">牛冧片(5磅)<input type="hidden"
                                                           id="code_3000013"
                                                           value="3000013"
                                                           class="no"></div>
                    <div id="item_1011"
                         class="item gp_165">西冷牛扒(5磅)<input type="hidden"
                                                            id="code_3000014"
                                                            value="3000014"
                                                            class="no"></div>
                    <div id="item_1012"
                         class="item gp_165">南乳豬手(5磅)<input type="hidden"
                                                            id="code_3001001"
                                                            value="3001001"
                                                            class="no"></div>
                    <div id="item_1013"
                         class="item gp_165">清湯腩(5磅)<input type="hidden"
                                                           id="code_3001002"
                                                           value="3001002"
                                                           class="no"></div>
                    <div id="item_1014"
                         class="item gp_165">爆腩仔(5磅)<input type="hidden"
                                                           id="code_3001003"
                                                           value="3001003"
                                                           class="no"></div>
                    <div id="item_1015"
                         class="item gp_165">豬軟骨(5磅)<input type="hidden"
                                                           id="code_3001004"
                                                           value="3001004"
                                                           class="no"></div>
                    <div id="item_1016"
                         class="item gp_166">豉油汁(5磅)<input type="hidden"
                                                           id="code_3002001"
                                                           value="3002001"
                                                           class="no"></div>
                    <div id="item_1017"
                         class="item gp_166">焗飯汁(5磅)<input type="hidden"
                                                           id="code_3002002"
                                                           value="3002002"
                                                           class="no"></div>
                    <div id="item_1018"
                         class="item gp_166">黑椒汁(5磅)<input type="hidden"
                                                           id="code_3002003"
                                                           value="3002003"
                                                           class="no"></div>
                    <div id="item_1019"
                         class="item gp_166">泰式海南雞汁(2磅)<input type="hidden"
                                                              id="code_3002004"
                                                              value="3002004"
                                                              class="no"></div>
                    <div id="item_1020"
                         class="item gp_166">咖喱魚旦汁(3磅)<input type="hidden"
                                                             id="code_3002005"
                                                             value="3002005"
                                                             class="no"></div>
                    <div id="item_1021"
                         class="item gp_166">白汁(3磅)<input type="hidden"
                                                          id="code_3002006"
                                                          value="3002006"
                                                          class="no"></div>
                    <div id="item_1022"
                         class="item gp_166">糖醋(10磅)<input type="hidden"
                                                           id="code_3002007"
                                                           value="3002007"
                                                           class="no"></div>
                    <div id="item_1023"
                         class="item gp_166">咖喱膽(5磅)<input type="hidden"
                                                           id="code_3002008"
                                                           value="3002008"
                                                           class="no"></div>
                    <div id="item_1024"
                         class="item gp_166">鳳爪醬(2磅)<input type="hidden"
                                                           id="code_3002009"
                                                           value="3002009"
                                                           class="no"></div>
                    <div id="item_1025"
                         class="item gp_166">蒜茸豆豉(5磅)<input type="hidden"
                                                            id="code_3003001"
                                                            value="3003001"
                                                            class="no"></div>
                    <div id="item_1026"
                         class="item gp_166">蘿蔔酸菜(5磅)<input type="hidden"
                                                            id="code_3003002"
                                                            value="3003002"
                                                            class="no"></div>
                    <div id="item_1027"
                         class="item gp_166">炒梅菜(2磅)<input type="hidden"
                                                           id="code_3003003"
                                                           value="3003003"
                                                           class="no"></div>
                    <div id="item_1028"
                         class="item gp_166">素冬菇(5磅)<input type="hidden"
                                                           id="code_3003004"
                                                           value="3003004"
                                                           class="no"></div>
                    <div id="item_1029"
                         class="item gp_166">台式肉燥(5磅)<input type="hidden"
                                                            id="code_3003005"
                                                            value="3003005"
                                                            class="no"></div>
                    <div id="item_1030"
                         class="item gp_166">鮑汁花膠(20隻)<input type="hidden"
                                                             id="code_3003006"
                                                             value="3003006"
                                                             class="no"></div>
                    <div id="item_1031"
                         class="item gp_167">蘿蔔糕<input type="hidden"
                                                       id="code_3004001"
                                                       value="3004001"
                                                       class="no"></div>
                    <div id="item_1032"
                         class="item gp_167">山竹牛肉球(30粒)<input type="hidden"
                                                              id="code_3004002"
                                                              value="3004002"
                                                              class="no"></div>
                    <div id="item_1033"
                         class="item gp_167">足料糯米雞(6個)<input type="hidden"
                                                             id="code_3004003"
                                                             value="3004003"
                                                             class="no"></div>
                    <div id="item_1034"
                         class="item gp_167">碗仔翅(2斤)<input type="hidden"
                                                           id="code_3004004"
                                                           value="3004004"
                                                           class="no"></div>
                    <div id="item_1035"
                         class="item gp_167">咸肉粥(5磅)<input type="hidden"
                                                           id="code_3004005"
                                                           value="3004005"
                                                           class="no"></div>
                    <div id="item_1036"
                         class="item gp_167">茶葉蛋(30隻)<input type="hidden"
                                                            id="code_3004006"
                                                            value="3004006"
                                                            class="no"></div>
                    <div id="item_1037"
                         class="item gp_167">肉醬(5磅)<input type="hidden"
                                                          id="code_3005001"
                                                          value="3005001"
                                                          class="no"></div>
                    <div id="item_1038"
                         class="item gp_167">咖喱牛肉餡(5磅)<input type="hidden"
                                                             id="code_3005002"
                                                             value="3005002"
                                                             class="no"></div>
                    <div id="item_1039"
                         class="item gp_167">叉燒包餡(5磅)<input type="hidden"
                                                            id="code_3005003"
                                                            value="3005003"
                                                            class="no"></div>
                    <div id="item_1040"
                         class="item gp_167">紅豆茸餡(5磅)<input type="hidden"
                                                            id="code_3005004"
                                                            value="3005004"
                                                            class="no"></div>
                    <div id="item_1041"
                         class="item gp_167">冰糖花膠(10隻)<input type="hidden"
                                                             id="code_3005005"
                                                             value="3005005"
                                                             class="no"></div>
                    <div id="item_1042"
                         class="item gp_168">叉燒絲炒麵(3磅)<input type="hidden"
                                                             id="code_3006001"
                                                             value="3006001"
                                                             class="no"></div>
                    <div id="item_1043"
                         class="item gp_168">蛋絲炒米(3磅)<input type="hidden"
                                                            id="code_3006002"
                                                            value="3006002"
                                                            class="no"></div>
                    <div id="item_1044"
                         class="item gp_168">炒銀針粉(3磅)<input type="hidden"
                                                            id="code_3006003"
                                                            value="3006003"
                                                            class="no"></div>
                    <div id="item_1045"
                         class="item gp_168">焗飯底(3磅)<input type="hidden"
                                                           id="code_3006004"
                                                           value="3006004"
                                                           class="no"></div>
                    <div id="item_1046"
                         class="item gp_168">焗意粉底(3磅)<input type="hidden"
                                                            id="code_3006005"
                                                            value="3006005"
                                                            class="no"></div>
                    <div id="item_1047"
                         class="item gp_169">豆漿<input type="hidden"
                                                      id="code_3007001"
                                                      value="3007001"
                                                      class="no"></div>
                    <div id="item_1048"
                         class="item gp_169">原凍奶茶<input type="hidden"
                                                        id="code_3007002"
                                                        value="3007002"
                                                        class="no"></div>
                    <div id="item_1049"
                         class="item gp_169">原凍咖啡<input type="hidden"
                                                        id="code_3007003"
                                                        value="3007003"
                                                        class="no"></div>
                    <div id="item_1050"
                         class="item gp_169">五花茶<input type="hidden"
                                                       id="code_3007004"
                                                       value="3007004"
                                                       class="no"></div>
                    <div id="item_1051"
                         class="item gp_169">柑桔檸蜜<input type="hidden"
                                                        id="code_3007005"
                                                        value="3007005"
                                                        class="no"></div>
                    <div id="item_1052"
                         class="item gp_169">凍齋啡(2kg)<input type="hidden"
                                                            id="code_3007006"
                                                            value="3007006"
                                                            class="no"></div>
                    <div id="item_1053"
                         class="item gp_170">宇治抹茶紅豆糕(3磅)<input type="hidden"
                                                               id="code_3200001"
                                                               value="3200001"
                                                               class="no"></div>
                    <div id="item_1054"
                         class="item gp_171">雞蛋(360隻)<input type="hidden"
                                                            id="code_4000001"
                                                            value="4000001"
                                                            class="no"></div>
                    <div id="item_1055"
                         class="item gp_171">火腿片(10磅)<input type="hidden"
                                                            id="code_4000002"
                                                            value="4000002"
                                                            class="no"></div>
                    <div id="item_1056"
                         class="item gp_171">26/30越南蝦仁(2kgx6)<input type="hidden"
                                                                    id="code_4000003"
                                                                    value="4000003"
                                                                    class="no"></div>
                    <div id="item_1057"
                         class="item gp_171">41/50越南蝦仁(2kgx6)<input type="hidden"
                                                                    id="code_4000004"
                                                                    value="4000004"
                                                                    class="no"></div>
                    <div id="item_1058"
                         class="item gp_171">51/60越南蝦仁(2kgx6)<input type="hidden"
                                                                    id="code_4000005"
                                                                    value="4000005"
                                                                    class="no"></div>
                    <div id="item_1059"
                         class="item gp_171">煙肉(2磅)<input type="hidden"
                                                          id="code_4001001"
                                                          value="4001001"
                                                          class="no"></div>
                    <div id="item_1060"
                         class="item gp_171">蟹棒肉(250g)<input type="hidden"
                                                             id="code_4001002"
                                                             value="4001002"
                                                             class="no"></div>
                    <div id="item_1061"
                         class="item gp_171">法蘭克福腸(8條)<input type="hidden"
                                                             id="code_4001003"
                                                             value="4001003"
                                                             class="no"></div>
                    <div id="item_1062"
                         class="item gp_171">半磅鮮牛油(227g)<input type="hidden"
                                                               id="code_4001004"
                                                               value="4001004"
                                                               class="no"></div>
                    <div id="item_1063"
                         class="item gp_171">芝士片(84片)<input type="hidden"
                                                            id="code_4001005"
                                                            value="4001005"
                                                            class="no"></div>
                    <div id="item_1064"
                         class="item gp_171">芝士碎(2kg)<input type="hidden"
                                                            id="code_4001006"
                                                            value="4001006"
                                                            class="no"></div>
                    <div id="item_1065"
                         class="item gp_171">車打芝士粒(1kg)<input type="hidden"
                                                              id="code_4001007"
                                                              value="4001007"
                                                              class="no"></div>
                    <div id="item_1066"
                         class="item gp_171">三色芝士碎(5磅)<input type="hidden"
                                                             id="code_4001008"
                                                             value="4001008"
                                                             class="no"></div>
                    <div id="item_1067"
                         class="item gp_171">咖啡忌廉奶(1L)<input type="hidden"
                                                             id="code_4001009"
                                                             value="4001009"
                                                             class="no"></div>
                    <div id="item_1068"
                         class="item gp_171">淡忌廉(1L)<input type="hidden"
                                                           id="code_4001010"
                                                           value="4001010"
                                                           class="no"></div>
                    <div id="item_1069"
                         class="item gp_171">榴槤(1kg)<input type="hidden"
                                                           id="code_4001011"
                                                           value="4001011"
                                                           class="no"></div>
                    <div id="item_1070"
                         class="item gp_171">炸魚柳(25)<input type="hidden"
                                                           id="code_4001012"
                                                           value="4001012"
                                                           class="no"></div>
                    <div id="item_1071"
                         class="item gp_172">砂糖(30kg)<input type="hidden"
                                                            id="code_4002001"
                                                            value="4002001"
                                                            class="no"></div>
                    <div id="item_1072"
                         class="item gp_172">白米(25kg)<input type="hidden"
                                                            id="code_4002002"
                                                            value="4002002"
                                                            class="no"></div>
                    <div id="item_1073"
                         class="item gp_172">生油(27斤)<input type="hidden"
                                                           id="code_4002003"
                                                           value="4002003"
                                                           class="no"></div>
                    <div id="item_1074"
                         class="item gp_172">蒙牛奶(1Lx12)<input type="hidden"
                                                              id="code_4002004"
                                                              value="4002004"
                                                              class="no"></div>
                    <div id="item_1075"
                         class="item gp_172">北海道牛乳(1Lx12)<input type="hidden"
                                                                id="code_4002005"
                                                                value="4002005"
                                                                class="no"></div>
                    <div id="item_1076"
                         class="item gp_172">火腿豬肉(340gx24)<input type="hidden"
                                                                 id="code_4002006"
                                                                 value="4002006"
                                                                 class="no"></div>
                    <div id="item_1077"
                         class="item gp_172">F&N全脂奶(400g48)<input type="hidden"
                                                                  id="code_4002007"
                                                                  value="4002007"
                                                                  class="no"></div>
                    <div id="item_1078"
                         class="item gp_172">意粉(3kgx4)<input type="hidden"
                                                             id="code_4002008"
                                                             value="4002008"
                                                             class="no"></div>
                    <div id="item_1079"
                         class="item gp_172">東和招牌麵(85gx36)<input type="hidden"
                                                                 id="code_4002009"
                                                                 value="4002009"
                                                                 class="no"></div>
                    <div id="item_1080"
                         class="item gp_172">同珍海鮮醬(10斤)<input type="hidden"
                                                              id="code_4002010"
                                                              value="4002010"
                                                              class="no"></div>
                    <div id="item_1081"
                         class="item gp_172">同珍辣椒醬(10斤)<input type="hidden"
                                                              id="code_4002011"
                                                              value="4002011"
                                                              class="no"></div>
                    <div id="item_1082"
                         class="item gp_172">椰絲(5磅)<input type="hidden"
                                                          id="code_4003001"
                                                          value="4003001"
                                                          class="no"></div>
                    <div id="item_1083"
                         class="item gp_172">白粉(5磅)<input type="hidden"
                                                          id="code_4003002"
                                                          value="4003002"
                                                          class="no"></div>
                    <div id="item_1084"
                         class="item gp_172">麥粉(5磅)<input type="hidden"
                                                          id="code_4003003"
                                                          value="4003003"
                                                          class="no"></div>
                    <div id="item_1085"
                         class="item gp_172">白芝麻(2斤)<input type="hidden"
                                                           id="code_4003004"
                                                           value="4003004"
                                                           class="no"></div>
                    <div id="item_1086"
                         class="item gp_172">幼鹽(3斤)<input type="hidden"
                                                          id="code_4003005"
                                                          value="4003005"
                                                          class="no"></div>
                    <div id="item_1087"
                         class="item gp_172">杏仁片(磅)<input type="hidden"
                                                          id="code_4003006"
                                                          value="4003006"
                                                          class="no"></div>
                    <div id="item_1088"
                         class="item gp_172">提子乾(3磅)<input type="hidden"
                                                           id="code_4003007"
                                                           value="4003007"
                                                           class="no"></div>
                    <div id="item_1089"
                         class="item gp_172">熟吉士粉(5磅)<input type="hidden"
                                                            id="code_4003008"
                                                            value="4003008"
                                                            class="no"></div>
                    <div id="item_1090"
                         class="item gp_171">藍莓醬(2磅)<input type="hidden"
                                                           id="code_4003009"
                                                           value="4003009"
                                                           class="no"></div>
                    <div id="item_1091"
                         class="item gp_172">果凍粉(200g)<input type="hidden"
                                                             id="code_4003010"
                                                             value="4003010"
                                                             class="no"></div>
                    <div id="item_1092"
                         class="item gp_172">無鋁泡打粉(4oz)<input type="hidden"
                                                              id="code_4004001"
                                                              value="4004001"
                                                              class="no"></div>
                    <div id="item_1093"
                         class="item gp_172">甜奶(390g)<input type="hidden"
                                                            id="code_4004002"
                                                            value="4004002"
                                                            class="no"></div>
                    <div id="item_1094"
                         class="item gp_172">鷹嘜煉奶(350g)<input type="hidden"
                                                              id="code_4004003"
                                                              value="4004003"
                                                              class="no"></div>
                    <div id="item_1095"
                         class="item gp_172">菠蘿粒(850g)<input type="hidden"
                                                             id="code_4004004"
                                                             value="4004004"
                                                             class="no"></div>
                    <div id="item_1096"
                         class="item gp_172">雜果(825g)<input type="hidden"
                                                            id="code_4004005"
                                                            value="4004005"
                                                            class="no"></div>
                    <div id="item_1097"
                         class="item gp_172">原片菠蘿(850g)<input type="hidden"
                                                              id="code_4004006"
                                                              value="4004006"
                                                              class="no"></div>
                    <div id="item_1098"
                         class="item gp_172">高美植脂淡奶(400g)<input type="hidden"
                                                                id="code_4004007"
                                                                value="4004007"
                                                                class="no"></div>
                    <div id="item_1099"
                         class="item gp_172">黃梅占(900g)<input type="hidden"
                                                             id="code_4004008"
                                                             value="4004008"
                                                             class="no"></div>
                    <div id="item_1100"
                         class="item gp_172">好立克(3.8kg)<input type="hidden"
                                                              id="code_4004009"
                                                              value="4004009"
                                                              class="no"></div>
                    <div id="item_1101"
                         class="item gp_172">阿華田(1.9kg)<input type="hidden"
                                                              id="code_4004010"
                                                              value="4004010"
                                                              class="no"></div>
                    <div id="item_1102"
                         class="item gp_172">午餐肉(1588g)<input type="hidden"
                                                              id="code_4004011"
                                                              value="4004011"
                                                              class="no"></div>
                    <div id="item_1103"
                         class="item gp_172">南順馬芝蓮(2.25kg)<input type="hidden"
                                                                 id="code_4004012"
                                                                 value="4004012"
                                                                 class="no"></div>
                    <div id="item_1104"
                         class="item gp_172">粟米粒(425g)<input type="hidden"
                                                             id="code_4004013"
                                                             value="4004013"
                                                             class="no"></div>
                    <div id="item_1105"
                         class="item gp_172">車打芝士汁(106oz)<input type="hidden"
                                                                id="code_4004014"
                                                                value="4004014"
                                                                class="no"></div>
                    <div id="item_1106"
                         class="item gp_172">茄汁(3.23kg)<input type="hidden"
                                                              id="code_4004015"
                                                              value="4004015"
                                                              class="no"></div>
                    <div id="item_1107"
                         class="item gp_172">蘑菇片(850g)<input type="hidden"
                                                             id="code_4004016"
                                                             value="4004016"
                                                             class="no"></div>
                    <div id="item_1108"
                         class="item gp_172">鹹牛肉(340g)<input type="hidden"
                                                             id="code_4004017"
                                                             value="4004017"
                                                             class="no"></div>
                    <div id="item_1109"
                         class="item gp_172">蘑菇碎片(2840g)<input type="hidden"
                                                               id="code_4004018"
                                                               value="4004018"
                                                               class="no"></div>
                    <div id="item_1110"
                         class="item gp_172">椰漿(400ml)<input type="hidden"
                                                             id="code_4004019"
                                                             value="4004019"
                                                             class="no"></div>
                    <div id="item_1111"
                         class="item gp_172">金寶忌廉雞湯(50oz)<input type="hidden"
                                                                id="code_4004020"
                                                                value="4004020"
                                                                class="no"></div>
                    <div id="item_1112"
                         class="item gp_172">生日糖牌(12個)<input type="hidden"
                                                             id="code_4005001"
                                                             value="4005001"
                                                             class="no"></div>
                    <div id="item_1113"
                         class="item gp_172">檸檬黃粉<input type="hidden"
                                                        id="code_4005002"
                                                        value="4005002"
                                                        class="no"></div>
                    <div id="item_1114"
                         class="item gp_172">久力雲呢嗱油<input type="hidden"
                                                          id="code_4005003"
                                                          value="4005003"
                                                          class="no"></div>
                    <div id="item_1115"
                         class="item gp_172">洋芫荽(番茜碎)<input type="hidden"
                                                            id="code_4005004"
                                                            value="4005004"
                                                            class="no"></div>
                    <div id="item_1116"
                         class="item gp_172">紅車厘子(26oz)<input type="hidden"
                                                              id="code_4005005"
                                                              value="4005005"
                                                              class="no"></div>
                    <div id="item_1117"
                         class="item gp_172">朱古力粉(500g)<input type="hidden"
                                                              id="code_4005006"
                                                              value="4005006"
                                                              class="no"></div>
                    <div id="item_1118"
                         class="item gp_172">花生醬(1kg)<input type="hidden"
                                                            id="code_4005007"
                                                            value="4005007"
                                                            class="no"></div>
                    <div id="item_1119"
                         class="item gp_172">東一堂菜蜜(650g)<input type="hidden"
                                                               id="code_4005008"
                                                               value="4005008"
                                                               class="no"></div>
                    <div id="item_1120"
                         class="item gp_172">沙律醬(3kg)<input type="hidden"
                                                            id="code_4005009"
                                                            value="4005009"
                                                            class="no"></div>
                    <div id="item_1121"
                         class="item gp_172">鷹粟粉(420g)<input type="hidden"
                                                             id="code_4005010"
                                                             value="4005010"
                                                             class="no"></div>
                    <div id="item_1122"
                         class="item gp_172">麵包糠(1kg)<input type="hidden"
                                                            id="code_4005011"
                                                            value="4005011"
                                                            class="no"></div>
                    <div id="item_1123"
                         class="item gp_172">燕麥片(800g)<input type="hidden"
                                                             id="code_4005012"
                                                             value="4005012"
                                                             class="no"></div>
                    <div id="item_1124"
                         class="item gp_172">原味肉鬆(2kg)<input type="hidden"
                                                             id="code_4005013"
                                                             value="4005013"
                                                             class="no"></div>
                    <div id="item_1125"
                         class="item gp_172">紫薯裝飾粉(1kg)<input type="hidden"
                                                              id="code_4005014"
                                                              value="4005014"
                                                              class="no"></div>
                    <div id="item_1126"
                         class="item gp_172">咖哩味薯蓉粉(1kg)<input type="hidden"
                                                               id="code_4005015"
                                                               value="4005015"
                                                               class="no"></div>
                    <div id="item_1127"
                         class="item gp_172">法寶辣味肉松(2kg)<input type="hidden"
                                                               id="code_4005016"
                                                               value="4005016"
                                                               class="no"></div>
                    <div id="item_1128"
                         class="item gp_172">黑椒碎(605g)<input type="hidden"
                                                             id="code_4005017"
                                                             value="4005017"
                                                             class="no"></div>
                    <div id="item_1129"
                         class="item gp_172">佛手味精(1磅)<input type="hidden"
                                                            id="code_4005018"
                                                            value="4005018"
                                                            class="no"></div>
                    <div id="item_1130"
                         class="item gp_172">廚師雞粉(1kg)<input type="hidden"
                                                             id="code_4005019"
                                                             value="4005019"
                                                             class="no"></div>
                    <div id="item_1131"
                         class="item gp_172">忌廉雞湯粉(900g)<input type="hidden"
                                                               id="code_4005020"
                                                               value="4005020"
                                                               class="no"></div>
                    <div id="item_1132"
                         class="item gp_172">米粉(3kg)<input type="hidden"
                                                           id="code_4005021"
                                                           value="4005021"
                                                           class="no"></div>
                    <div id="item_1133"
                         class="item gp_172">卡夫芝士粉(85g)<input type="hidden"
                                                              id="code_4005022"
                                                              value="4005022"
                                                              class="no"></div>
                    <div id="item_1134"
                         class="item gp_172">橄欖油(1L)<input type="hidden"
                                                           id="code_4005023"
                                                           value="4005023"
                                                           class="no"></div>
                    <div id="item_1135"
                         class="item gp_172">大冧酒(100cl)<input type="hidden"
                                                              id="code_4005024"
                                                              value="4005024"
                                                              class="no"></div>
                    <div id="item_1136"
                         class="item gp_172">鰻魚汁(1.8L)<input type="hidden"
                                                             id="code_4005025"
                                                             value="4005025"
                                                             class="no"></div>
                    <div id="item_1137"
                         class="item gp_172">喼汁(600ml)<input type="hidden"
                                                             id="code_4005026"
                                                             value="4005026"
                                                             class="no"></div>
                    <div id="item_1138"
                         class="item gp_172">辣椒油(500ml)<input type="hidden"
                                                              id="code_4005027"
                                                              value="4005027"
                                                              class="no"></div>
                    <div id="item_1139"
                         class="item gp_173">雞蛋卷(12盒)<input type="hidden"
                                                            id="code_4100001"
                                                            value="4100001"
                                                            class="no"></div>
                    <div id="item_1140"
                         class="item gp_173">鳳凰卷(12盒)<input type="hidden"
                                                            id="code_4100002"
                                                            value="4100002"
                                                            class="no"></div>
                    <div id="item_1141"
                         class="item gp_173">龜苓膏(24杯)<input type="hidden"
                                                            id="code_4100003"
                                                            value="4100003"
                                                            class="no"></div>
                    <div id="item_1142"
                         class="item gp_173">茯苓膏(24杯)<input type="hidden"
                                                            id="code_4100004"
                                                            value="4100004"
                                                            class="no"></div>
                    <div id="item_1143"
                         class="item gp_173">蛋撻王沙琪瑪(60包)<input type="hidden"
                                                               id="code_4100005"
                                                               value="4100005"
                                                               class="no"></div>
                    <div id="item_1144"
                         class="item gp_173">蛋撻王蝴蝶酥(72包)<input type="hidden"
                                                               id="code_4100006"
                                                               value="4100006"
                                                               class="no"></div>
                    <div id="item_1145"
                         class="item gp_173">蛋撻王芝士酥(72包)<input type="hidden"
                                                               id="code_4100007"
                                                               value="4100007"
                                                               class="no"></div>
                    <div id="item_1146"
                         class="item gp_173">蛋撻王提子酥(72包)<input type="hidden"
                                                               id="code_4100008"
                                                               value="4100008"
                                                               class="no"></div>
                    <div id="item_1147"
                         class="item gp_173">蛋撻預拌粉(10盒)<input type="hidden"
                                                              id="code_4100009"
                                                              value="4100009"
                                                              class="no"></div>
                    <div id="item_1148"
                         class="item gp_174">奶茶掛牌(100)<input type="hidden"
                                                             id="code_4201001"
                                                             value="4201001"
                                                             class="no"></div>
                    <div id="item_1149"
                         class="item gp_174">咖啡掛牌(100)<input type="hidden"
                                                             id="code_4201002"
                                                             value="4201002"
                                                             class="no"></div>
                    <div id="item_1150"
                         class="item gp_174">豆漿掛牌(100)<input type="hidden"
                                                             id="code_4201003"
                                                             value="4201003"
                                                             class="no"></div>
                    <div id="item_1151"
                         class="item gp_174">五花茶掛牌(100)<input type="hidden"
                                                              id="code_4201004"
                                                              value="4201004"
                                                              class="no"></div>
                    <div id="item_1152"
                         class="item gp_174">柑桔檸蜜掛牌(100)<input type="hidden"
                                                               id="code_4201005"
                                                               value="4201005"
                                                               class="no"></div>
                    <div id="item_1153"
                         class="item gp_174">掛牌-湯種方包(100)<input type="hidden"
                                                                id="code_4201006"
                                                                value="4201006"
                                                                class="no"></div>
                    <div id="item_1154"
                         class="item gp_174">掛牌-湯種芝士方包(100)<input type="hidden"
                                                                  id="code_4201007"
                                                                  value="4201007"
                                                                  class="no"></div>
                    <div id="item_1155"
                         class="item gp_174">掛牌-湯種葡萄方包(100)<input type="hidden"
                                                                  id="code_4201008"
                                                                  value="4201008"
                                                                  class="no"></div>
                    <div id="item_1156"
                         class="item gp_174">餅店Logo貼紙(50張*15個)<input type="hidden"
                                                                     id="code_4201009"
                                                                     value="4201009"
                                                                     class="no"></div>
                    <div id="item_1157"
                         class="item gp_174">外帶站Logo貼紙(50張*10個)<input type="hidden"
                                                                      id="code_4201010"
                                                                      value="4201010"
                                                                      class="no"></div>
                    <div id="item_1158"
                         class="item gp_174">方包貼紙(50張*10個)<input type="hidden"
                                                                 id="code_4201011"
                                                                 value="4201011"
                                                                 class="no"></div>
                    <div id="item_1159"
                         class="item gp_174">全麥方包貼紙(50張*10個)<input type="hidden"
                                                                   id="code_4201012"
                                                                   value="4201012"
                                                                   class="no"></div>
                    <div id="item_1160"
                         class="item gp_174">英式方包貼紙(50張*10個)<input type="hidden"
                                                                   id="code_4201013"
                                                                   value="4201013"
                                                                   class="no"></div>
                    <div id="item_1161"
                         class="item gp_174">厚切方包貼紙(50張*10個)<input type="hidden"
                                                                   id="code_4201014"
                                                                   value="4201014"
                                                                   class="no"></div>
                    <div id="item_1162"
                         class="item gp_174">瑞士卷貼紙(50張*10個)<input type="hidden"
                                                                  id="code_4201015"
                                                                  value="4201015"
                                                                  class="no"></div>
                    <div id="item_1163"
                         class="item gp_174">芝士蛋糕黏貼紙帶(500)<input type="hidden"
                                                                 id="code_4201016"
                                                                 value="4201016"
                                                                 class="no"></div>
                    <div id="item_1164"
                         class="item gp_174">OPP12+1.25方包袋(1000)<input type="hidden"
                                                                       id="code_4202001"
                                                                       value="4202001"
                                                                       class="no"></div>
                    <div id="item_1165"
                         class="item gp_174">OPP12+2 湯種方包袋(1000)<input type="hidden"
                                                                       id="code_4202002"
                                                                       value="4202002"
                                                                       class="no"></div>
                    <div id="item_1166"
                         class="item gp_174">OPP6+2 戚風袋(1000)<input type="hidden"
                                                                    id="code_4202003"
                                                                    value="4202003"
                                                                    class="no"></div>
                    <div id="item_1167"
                         class="item gp_174">OPP13+1 迷你包袋(1000)<input type="hidden"
                                                                      id="code_4202004"
                                                                      value="4202004"
                                                                      class="no"></div>
                    <div id="item_1168"
                         class="item gp_174">7x9個裝麵包袋(1000)<input type="hidden"
                                                                  id="code_4202005"
                                                                  value="4202005"
                                                                  class="no"></div>
                    <div id="item_1169"
                         class="item gp_174">蛋撻王透明吊帶袋(20x5)<input type="hidden"
                                                                  id="code_4202006"
                                                                  value="4202006"
                                                                  class="no"></div>
                    <div id="item_1170"
                         class="item gp_174">兩件蛋撻紙袋(100)<input type="hidden"
                                                               id="code_4202007"
                                                               value="4202007"
                                                               class="no"></div>
                    <div id="item_1171"
                         class="item gp_174">#145光身麵包袋(2000)<input type="hidden"
                                                                   id="code_4202008"
                                                                   value="4202008"
                                                                   class="no"></div>
                    <div id="item_1172"
                         class="item gp_174">#155印嘜麵包袋(1000)<input type="hidden"
                                                                   id="code_4202009"
                                                                   value="4202009"
                                                                   class="no"></div>
                    <div id="item_1173"
                         class="item gp_174">#180印嘜麵包袋(1000)<input type="hidden"
                                                                   id="code_4202010"
                                                                   value="4202010"
                                                                   class="no"></div>
                    <div id="item_1174"
                         class="item gp_174">細-啡牛皮紙袋(1200)<input type="hidden"
                                                                 id="code_4202011"
                                                                 value="4202011"
                                                                 class="no"></div>
                    <div id="item_1175"
                         class="item gp_174">大-啡牛皮紙袋(1000)<input type="hidden"
                                                                 id="code_4202012"
                                                                 value="4202012"
                                                                 class="no"></div>
                    <div id="item_1176"
                         class="item gp_174">細-白色印嘜手挽袋(1000)<input type="hidden"
                                                                   id="code_4202013"
                                                                   value="4202013"
                                                                   class="no"></div>
                    <div id="item_1177"
                         class="item gp_174">中-白色印嘜手挽袋(1000)<input type="hidden"
                                                                   id="code_4202014"
                                                                   value="4202014"
                                                                   class="no"></div>
                    <div id="item_1178"
                         class="item gp_174">大-白色印嘜手挽袋(500)<input type="hidden"
                                                                  id="code_4202015"
                                                                  value="4202015"
                                                                  class="no"></div>
                    <div id="item_1179"
                         class="item gp_174">三磅蛋糕盒<input type="hidden"
                                                         id="code_4203001"
                                                         value="4203001"
                                                         class="no"></div>
                    <div id="item_1180"
                         class="item gp_174">四磅蛋糕盒<input type="hidden"
                                                         id="code_4203002"
                                                         value="4203002"
                                                         class="no"></div>
                    <div id="item_1181"
                         class="item gp_174">五磅蛋糕盒<input type="hidden"
                                                         id="code_4203003"
                                                         value="4203003"
                                                         class="no"></div>
                    <div id="item_1182"
                         class="item gp_174">大圓蛋糕盒<input type="hidden"
                                                         id="code_4203004"
                                                         value="4203004"
                                                         class="no"></div>
                    <div id="item_1183"
                         class="item gp_174">370ml奶茶樽連蓋(216)<input type="hidden"
                                                                   id="code_4203005"
                                                                   value="4203005"
                                                                   class="no"></div>
                    <div id="item_1184"
                         class="item gp_174">冷泡茶樽(100)<input type="hidden"
                                                             id="code_4203006"
                                                             value="4203006"
                                                             class="no"></div>
                    <div id="item_1185"
                         class="item gp_174">黑色糯米雞盒連蓋(50)<input type="hidden"
                                                                id="code_4203007"
                                                                value="4203007"
                                                                class="no"></div>
                    <div id="item_1186"
                         class="item gp_174">到會箱<input type="hidden"
                                                       id="code_4203008"
                                                       value="4203008"
                                                       class="no"></div>
                    <div id="item_1187"
                         class="item gp_174">到會箱分格咭紙<input type="hidden"
                                                           id="code_4203009"
                                                           value="4203009"
                                                           class="no"></div>
                    <div id="item_1188"
                         class="item gp_174">黑色到會盆連蓋<input type="hidden"
                                                           id="code_4203010"
                                                           value="4203010"
                                                           class="no"></div>
                    <div id="item_1189"
                         class="item gp_174">到會鍚盆連蓋<input type="hidden"
                                                          id="code_4203011"
                                                          value="4203011"
                                                          class="no"></div>
                    <div id="item_1190"
                         class="item gp_174">三文治吸塑(200)  <input type="hidden"
                                                                id="code_4203012"
                                                                value="4203012"
                                                                class="no"></div>
                    <div id="item_1191"
                         class="item gp_174">瑞士卷吸塑底連蓋(167)<input type="hidden"
                                                                 id="code_4203013"
                                                                 value="4203013"
                                                                 class="no"></div>
                    <div id="item_1192"
                         class="item gp_174">芝士蛋糕吸塑(125)<input type="hidden"
                                                               id="code_4203014"
                                                               value="4203014"
                                                               class="no"></div>
                    <div id="item_1193"
                         class="item gp_174">4件蛋撻盒(200)<input type="hidden"
                                                              id="code_4203015"
                                                              value="4203015"
                                                              class="no"></div>
                    <div id="item_1194"
                         class="item gp_174">6件蛋撻盒(200)<input type="hidden"
                                                              id="code_4203016"
                                                              value="4203016"
                                                              class="no"></div>
                    <div id="item_1195"
                         class="item gp_174">8x4.5 什餅盒(200)<input type="hidden"
                                                                  id="code_4203017"
                                                                  value="4203017"
                                                                  class="no"></div>
                    <div id="item_1196"
                         class="item gp_174">5.5x5.5 蛋糕盒(100)<input type="hidden"
                                                                    id="code_4203018"
                                                                    value="4203018"
                                                                    class="no"></div>
                    <div id="item_1197"
                         class="item gp_174">9x9 蛋糕盒(100)<input type="hidden"
                                                                id="code_4203019"
                                                                value="4203019"
                                                                class="no"></div>
                    <div id="item_1198"
                         class="item gp_174">金線<input type="hidden"
                                                      id="code_4204001"
                                                      value="4204001"
                                                      class="no"></div>
                    <div id="item_1199"
                         class="item gp_174">珍珠繩<input type="hidden"
                                                       id="code_4204002"
                                                       value="4204002"
                                                       class="no"></div>
                    <div id="item_1200"
                         class="item gp_174">數字腊燭(50)<input type="hidden"
                                                            id="code_4204003"
                                                            value="4204003"
                                                            class="no"></div>
                    <div id="item_1201"
                         class="item gp_174">Happy Birthday膠插牌(100)<input type="hidden"
                                                                          id="code_4204004"
                                                                          value="4204004"
                                                                          class="no"></div>
                    <div id="item_1202"
                         class="item gp_174">餅刀+蠟燭(100)<input type="hidden"
                                                              id="code_4204005"
                                                              value="4204005"
                                                              class="no"></div>
                    <div id="item_1203"
                         class="item gp_174">3.5吋牛乳卷膠紙(500)<input type="hidden"
                                                                  id="code_4204006"
                                                                  value="4204006"
                                                                  class="no"></div>
                    <div id="item_1204"
                         class="item gp_174">9寸飲筒<input type="hidden"
                                                        id="code_4204007"
                                                        value="4204007"
                                                        class="no"></div>
                    <div id="item_1205"
                         class="item gp_174">5吋透明茶更(100)<input type="hidden"
                                                               id="code_4204008"
                                                               value="4204008"
                                                               class="no"></div>
                    <div id="item_1206"
                         class="item gp_174">黑色膠刀(100)<input type="hidden"
                                                             id="code_4204009"
                                                             value="4204009"
                                                             class="no"></div>
                    <div id="item_1207"
                         class="item gp_174">5吋印嘜麵包紙托(300)<input type="hidden"
                                                                 id="code_4204010"
                                                                 value="4204010"
                                                                 class="no"></div>
                    <div id="item_1208"
                         class="item gp_174">長型印嘜麵包紙托(300)<input type="hidden"
                                                                 id="code_4204011"
                                                                 value="4204011"
                                                                 class="no"></div>
                    <div id="item_1209"
                         class="item gp_174">6吋印嘜Pizza紙托(300)<input type="hidden"
                                                                    id="code_4204012"
                                                                    value="4204012"
                                                                    class="no"></div>
                    <div id="item_1210"
                         class="item gp_174">5x3.5 咭紙(2000)<input type="hidden"
                                                                  id="code_4204013"
                                                                  value="4204013"
                                                                  class="no"></div>
                    <div id="item_1211"
                         class="item gp_174">外賣咭紙-大(50)<input type="hidden"
                                                              id="code_4204014"
                                                              value="4204014"
                                                              class="no"></div>
                    <div id="item_1212"
                         class="item gp_174">外賣咭紙-中(50)<input type="hidden"
                                                              id="code_4204015"
                                                              value="4204015"
                                                              class="no"></div>
                    <div id="item_1213"
                         class="item gp_174">外賣咭紙-細(50)<input type="hidden"
                                                              id="code_4204016"
                                                              value="4204016"
                                                              class="no"></div>
                    <div id="item_1214"
                         class="item gp_174">沙律夾<input type="hidden"
                                                       id="code_4204017"
                                                       value="4204017"
                                                       class="no"></div>
                    <div id="item_1215"
                         class="item gp_174">7吋到會碟(100隻)<input type="hidden"
                                                               id="code_4204018"
                                                               value="4204018"
                                                               class="no"></div>
                    <div id="item_1216"
                         class="item gp_174">印嘜餐紙(50包/箱)<input type="hidden"
                                                               id="code_4204019"
                                                               value="4204019"
                                                               class="no"></div>
                    <div id="item_1217"
                         class="item gp_174">1oz醬油杯連蓋(250)<input type="hidden"
                                                                 id="code_4204020"
                                                                 value="4204020"
                                                                 class="no"></div>
                    <div id="item_1218"
                         class="item gp_174">蒸飯錫兜(125)<input type="hidden"
                                                             id="code_4204021"
                                                             value="4204021"
                                                             class="no"></div>
                    <div id="item_1219"
                         class="item gp_174">#7650錫兜連蓋(125)<input type="hidden"
                                                                  id="code_4204022"
                                                                  value="4204022"
                                                                  class="no"></div>
                    <div id="item_1220"
                         class="item gp_175">黃色爽潔布(12)<input type="hidden"
                                                             id="code_4300001"
                                                             value="4300001"
                                                             class="no"></div>
                    <div id="item_1221"
                         class="item gp_175">桃紅色爽潔布(12)<input type="hidden"
                                                              id="code_4300002"
                                                              value="4300002"
                                                              class="no"></div>
                    <div id="item_1222"
                         class="item gp_175">白毛巾(12)<input type="hidden"
                                                           id="code_4300003"
                                                           value="4300003"
                                                           class="no"></div>
                    <div id="item_1223"
                         class="item gp_175">藍色醫生手套 (S)<input type="hidden"
                                                              id="code_4300004"
                                                              value="4300004"
                                                              class="no"></div>
                    <div id="item_1224"
                         class="item gp_175">藍色醫生手套(M)<input type="hidden"
                                                             id="code_4300005"
                                                             value="4300005"
                                                             class="no"></div>
                    <div id="item_1225"
                         class="item gp_175">藍色醫生手套(L)<input type="hidden"
                                                             id="code_4300006"
                                                             value="4300006"
                                                             class="no"></div>
                    <div id="item_1226"
                         class="item gp_175">紅色膠手套(S)<input type="hidden"
                                                            id="code_4300007"
                                                            value="4300007"
                                                            class="no"></div>
                    <div id="item_1227"
                         class="item gp_175">紅色膠手套(M)<input type="hidden"
                                                            id="code_4300008"
                                                            value="4300008"
                                                            class="no"></div>
                    <div id="item_1228"
                         class="item gp_175">紅色膠手套(L)<input type="hidden"
                                                            id="code_4300009"
                                                            value="4300009"
                                                            class="no"></div>
                    <div id="item_1229"
                         class="item gp_175">黑色膠手套(S)<input type="hidden"
                                                            id="code_4300010"
                                                            value="4300010"
                                                            class="no"></div>
                    <div id="item_1230"
                         class="item gp_175">黑色膠手套(M)<input type="hidden"
                                                            id="code_4300011"
                                                            value="4300011"
                                                            class="no"></div>
                    <div id="item_1231"
                         class="item gp_175">黑色膠手套(L)<input type="hidden"
                                                            id="code_4300012"
                                                            value="4300012"
                                                            class="no"></div>
                    <div id="item_1232"
                         class="item gp_175">啡色百潔磚(5)<input type="hidden"
                                                            id="code_4300013"
                                                            value="4300013"
                                                            class="no"></div>
                    <div id="item_1233"
                         class="item gp_175">爐灶除油劑(5Ltr)<input type="hidden"
                                                               id="code_4300014"
                                                               value="4300014"
                                                               class="no"></div>
                    <div id="item_1234"
                         class="item gp_175">手洗清潔劑(5Ltr)<input type="hidden"
                                                               id="code_4300015"
                                                               value="4300015"
                                                               class="no"></div>
                    <div id="item_1235"
                         class="item gp_175">漂白水(5L)<input type="hidden"
                                                           id="code_4300016"
                                                           value="4300016"
                                                           class="no"></div>
                    <div id="item_1236"
                         class="item gp_176">3M膠布<input type="hidden"
                                                        id="code_4301001"
                                                        value="4301001"
                                                        class="no"></div>
                    <div id="item_1237"
                         class="item gp_176">三層口罩(50)<input type="hidden"
                                                            id="code_4301002"
                                                            value="4301002"
                                                            class="no"></div>
                    <div id="item_1238"
                         class="item gp_176">髮網(100)<input type="hidden"
                                                           id="code_4301003"
                                                           value="4301003"
                                                           class="no"></div>
                    <div id="item_1239"
                         class="item gp_176">廁紙(10)<input type="hidden"
                                                          id="code_4301004"
                                                          value="4301004"
                                                          class="no"></div>
                    <div id="item_1240"
                         class="item gp_176">黑色垃圾袋(25)<input type="hidden"
                                                             id="code_4301005"
                                                             value="4301005"
                                                             class="no"></div>
                    <div id="item_1241"
                         class="item gp_176">抹手紙<input type="hidden"
                                                       id="code_4301006"
                                                       value="4301006"
                                                       class="no"></div>
                    <div id="item_1242"
                         class="item gp_176">雪櫃溫濕度計<input type="hidden"
                                                          id="code_4301007"
                                                          value="4301007"
                                                          class="no"></div>
                    <div id="item_1243"
                         class="item gp_176">溫度/濕度計(有記憶)<input type="hidden"
                                                               id="code_4301008"
                                                               value="4301008"
                                                               class="no"></div>
                    <div id="item_1244"
                         class="item gp_176">白布紙(20)<input type="hidden"
                                                           id="code_4301009"
                                                           value="4301009"
                                                           class="no"></div>
                    <div id="item_1245"
                         class="item gp_176">入爐紙(20)<input type="hidden"
                                                           id="code_4301010"
                                                           value="4301010"
                                                           class="no"></div>
                    <div id="item_1246"
                         class="item gp_176">唧袋(72)<input type="hidden"
                                                          id="code_4301011"
                                                          value="4301011"
                                                          class="no"></div>
                    <div id="item_1247"
                         class="item gp_176">盒裝保鮮紙(18吋)<input type="hidden"
                                                              id="code_4301012"
                                                              value="4301012"
                                                              class="no"></div>
                    <div id="item_1248"
                         class="item gp_176">Release Spray噴油 600ml<input type="hidden"
                                                                         id="code_4301013"
                                                                         value="4301013"
                                                                         class="no"></div>
                    <div id="item_1249"
                         class="item gp_177">麵飽夾<input type="hidden"
                                                       id="code_4302001"
                                                       value="4302001"
                                                       class="no"></div>
                    <div id="item_1250"
                         class="item gp_177">Logo 四方托盆<input type="hidden"
                                                             id="code_4302002"
                                                             value="4302002"
                                                             class="no"></div>
                    <div id="item_1251"
                         class="item gp_177">大五常盒(#2001A)<input type="hidden"
                                                                id="code_4302003"
                                                                value="4302003"
                                                                class="no"></div>
                    <div id="item_1252"
                         class="item gp_177">中五常盒(#2003A)<input type="hidden"
                                                                id="code_4302004"
                                                                value="4302004"
                                                                class="no"></div>
                    <div id="item_1253"
                         class="item gp_177">細五常盒(#2004A)<input type="hidden"
                                                                id="code_4302005"
                                                                value="4302005"
                                                                class="no"></div>
                    <div id="item_1254"
                         class="item gp_177">#1817-矮箱蓋<input type="hidden"
                                                             id="code_4302006"
                                                             value="4302006"
                                                             class="no"></div>
                    <div id="item_1255"
                         class="item gp_177">#1818-高箱蓋<input type="hidden"
                                                             id="code_4302007"
                                                             value="4302007"
                                                             class="no"></div>
                    <div id="item_1256"
                         class="item gp_177">羊毛蛋掃<input type="hidden"
                                                        id="code_4302008"
                                                        value="4302008"
                                                        class="no"></div>
                    <div id="item_1257"
                         class="item gp_177">10吋膠柄牙刀<input type="hidden"
                                                           id="code_4302009"
                                                           value="4302009"
                                                           class="no"></div>
                    <div id="item_1258"
                         class="item gp_177">張小泉強力剪(藍柄)<input type="hidden"
                                                              id="code_4302010"
                                                              value="4302010"
                                                              class="no"></div>
                    <div id="item_1259"
                         class="item gp_177">安全罐頭刀<input type="hidden"
                                                         id="code_4302011"
                                                         value="4302011"
                                                         class="no"></div>
                    <div id="item_1260"
                         class="item gp_178">訂餅簿<input type="hidden"
                                                       id="code_4303001"
                                                       value="4303001"
                                                       class="no"></div>
                    <div id="item_1261"
                         class="item gp_178">外賣簿(快餐)<input type="hidden"
                                                           id="code_4303002"
                                                           value="4303002"
                                                           class="no"></div>
                    <div id="item_1262"
                         class="item gp_178">外賣簿(共食薈)<input type="hidden"
                                                            id="code_4303003"
                                                            value="4303003"
                                                            class="no"></div>
                    <div id="item_1263"
                         class="item gp_178">公司禮券封套(100)<input type="hidden"
                                                               id="code_4303004"
                                                               value="4303004"
                                                               class="no"></div>
                    <div id="item_1264"
                         class="item gp_178">2 吋橡根<input type="hidden"
                                                         id="code_4303005"
                                                         value="4303005"
                                                         class="no"></div>
                    <div id="item_1265"
                         class="item gp_178">印嘜日期機紙(10)<input type="hidden"
                                                              id="code_4303006"
                                                              value="4303006"
                                                              class="no"></div>
                    <div id="item_1266"
                         class="item gp_178">電腦收銀機紙(5)<input type="hidden"
                                                             id="code_4303007"
                                                             value="4303007"
                                                             class="no"></div>
                    <div id="item_1267"
                         class="item gp_178">A4 紙<input type="hidden"
                                                        id="code_4303008"
                                                        value="4303008"
                                                        class="no"></div>
                    <div id="item_1268"
                         class="item gp_178">獨立膠紙(5)<input type="hidden"
                                                           id="code_4303009"
                                                           value="4303009"
                                                           class="no"></div>
                    <div id="item_1269"
                         class="item gp_178">Estape 獨立膠紙座<input type="hidden"
                                                                id="code_4303010"
                                                                value="4303010"
                                                                class="no"></div>
                    <div id="item_1270"
                         class="item gp_178">價錢咭掛牌<input type="hidden"
                                                         id="code_4303011"
                                                         value="4303011"
                                                         class="no"></div>
                    <div id="item_1271"
                         class="item gp_179">橙/黑風褸(S)<input type="hidden"
                                                            id="code_4304001"
                                                            value="4304001"
                                                            class="no"></div>
                    <div id="item_1272"
                         class="item gp_179">橙/黑風褸(M)<input type="hidden"
                                                            id="code_4304002"
                                                            value="4304002"
                                                            class="no"></div>
                    <div id="item_1273"
                         class="item gp_179">橙/黑風褸(L)<input type="hidden"
                                                            id="code_4304003"
                                                            value="4304003"
                                                            class="no"></div>
                    <div id="item_1274"
                         class="item gp_179">橙/黑風褸XL)<input type="hidden"
                                                            id="code_4304004"
                                                            value="4304004"
                                                            class="no"></div>
                    <div id="item_1275"
                         class="item gp_179">橙/黑風褸(XXL)<input type="hidden"
                                                              id="code_4304005"
                                                              value="4304005"
                                                              class="no"></div>
                    <div id="item_1276"
                         class="item gp_179">黑色廚帽<input type="hidden"
                                                        id="code_4304006"
                                                        value="4304006"
                                                        class="no"></div>
                    <div id="item_1277"
                         class="item gp_179">黑色貝雷帽<input type="hidden"
                                                         id="code_4304007"
                                                         value="4304007"
                                                         class="no"></div>
                    <div id="item_1278"
                         class="item gp_179">黑色鴨舌帽<input type="hidden"
                                                         id="code_4304008"
                                                         value="4304008"
                                                         class="no"></div>
                    <div id="item_1279"
                         class="item gp_179">格仔廚褲(S)<input type="hidden"
                                                           id="code_4304009"
                                                           value="4304009"
                                                           class="no"></div>
                    <div id="item_1280"
                         class="item gp_179">格仔廚褲(M)<input type="hidden"
                                                           id="code_4304010"
                                                           value="4304010"
                                                           class="no"></div>
                    <div id="item_1281"
                         class="item gp_179">格仔廚褲(L)<input type="hidden"
                                                           id="code_4304011"
                                                           value="4304011"
                                                           class="no"></div>
                    <div id="item_1282"
                         class="item gp_179">格仔廚褲(XL)<input type="hidden"
                                                            id="code_4304012"
                                                            value="4304012"
                                                            class="no"></div>
                    <div id="item_1283"
                         class="item gp_179">格仔廚褲(XXL)<input type="hidden"
                                                             id="code_4304013"
                                                             value="4304013"
                                                             class="no"></div>
                    <div id="item_1284"
                         class="item gp_179">單襟短袖廚衣(S)<input type="hidden"
                                                             id="code_4304014"
                                                             value="4304014"
                                                             class="no"></div>
                    <div id="item_1285"
                         class="item gp_179">單襟短袖廚衣(M)<input type="hidden"
                                                             id="code_4304015"
                                                             value="4304015"
                                                             class="no"></div>
                    <div id="item_1286"
                         class="item gp_179">單襟短袖廚衣(L)<input type="hidden"
                                                             id="code_4304016"
                                                             value="4304016"
                                                             class="no"></div>
                    <div id="item_1287"
                         class="item gp_179">單襟短袖廚衣(XL)<input type="hidden"
                                                              id="code_4304017"
                                                              value="4304017"
                                                              class="no"></div>
                    <div id="item_1288"
                         class="item gp_179">單襟短袖廚衣(XXL)<input type="hidden"
                                                               id="code_4304018"
                                                               value="4304018"
                                                               class="no"></div>
                    <div id="item_1289"
                         class="item gp_179">孖襟短袖廚衣(S)<input type="hidden"
                                                             id="code_4304019"
                                                             value="4304019"
                                                             class="no"></div>
                    <div id="item_1290"
                         class="item gp_179">孖襟短袖廚衣(M)<input type="hidden"
                                                             id="code_4304020"
                                                             value="4304020"
                                                             class="no"></div>
                    <div id="item_1291"
                         class="item gp_179">孖襟短袖廚衣(L)<input type="hidden"
                                                             id="code_4304021"
                                                             value="4304021"
                                                             class="no"></div>
                    <div id="item_1292"
                         class="item gp_179">孖襟短袖廚衣(XL)<input type="hidden"
                                                              id="code_4304022"
                                                              value="4304022"
                                                              class="no"></div>
                    <div id="item_1293"
                         class="item gp_179">孖襟短袖廚衣(XXL)<input type="hidden"
                                                               id="code_4304023"
                                                               value="4304023"
                                                               class="no"></div>
                    <div id="item_1294"
                         class="item gp_179">黑色半截圍裙<input type="hidden"
                                                          id="code_4304024"
                                                          value="4304024"
                                                          class="no"></div>
                    <div id="item_1295"
                         class="item gp_179">黑色半截圍裙(麵包工房)<input type="hidden"
                                                                id="code_4304025"
                                                                value="4304025"
                                                                class="no"></div>
                    <div id="item_1296"
                         class="item gp_179">黑色連身圍裙<input type="hidden"
                                                          id="code_4304026"
                                                          value="4304026"
                                                          class="no"></div>
                    <div id="item_1297"
                         class="item gp_179">橙色短袖Polo(S)<input type="hidden"
                                                               id="code_4304027"
                                                               value="4304027"
                                                               class="no"></div>
                    <div id="item_1298"
                         class="item gp_179">橙色短袖Polo(M)<input type="hidden"
                                                               id="code_4304028"
                                                               value="4304028"
                                                               class="no"></div>
                    <div id="item_1299"
                         class="item gp_179">橙色短袖Polo(L)<input type="hidden"
                                                               id="code_4304029"
                                                               value="4304029"
                                                               class="no"></div>
                    <div id="item_1300"
                         class="item gp_179">橙色短袖Polo(XL)<input type="hidden"
                                                                id="code_4304030"
                                                                value="4304030"
                                                                class="no"></div>
                    <div id="item_1301"
                         class="item gp_179">橙色短袖Polo(XXL)<input type="hidden"
                                                                 id="code_4304031"
                                                                 value="4304031"
                                                                 class="no"></div>
                    <div id="item_1302"
                         class="item gp_179">圓領橙色短袖T恤(S)<input type="hidden"
                                                               id="code_4304032"
                                                               value="4304032"
                                                               class="no"></div>
                    <div id="item_1303"
                         class="item gp_179">圓領橙色短袖T恤(M)<input type="hidden"
                                                               id="code_4304033"
                                                               value="4304033"
                                                               class="no"></div>
                    <div id="item_1304"
                         class="item gp_179">圓領橙色短袖T恤(L)<input type="hidden"
                                                               id="code_4304034"
                                                               value="4304034"
                                                               class="no"></div>
                    <div id="item_1305"
                         class="item gp_179">圓領橙色短袖T恤(XL)<input type="hidden"
                                                                id="code_4304035"
                                                                value="4304035"
                                                                class="no"></div>
                    <div id="item_1306"
                         class="item gp_179">圓領橙色短袖T恤(XXL)<input type="hidden"
                                                                 id="code_4304036"
                                                                 value="4304036"
                                                                 class="no"></div>
                    <div id="item_1308"
                         class="item gp_151">香草蕃茄薯仔麵<input type="hidden"
                                                           id="code_1007012"
                                                           value="1007012"
                                                           class="no"></div>
                    <div id="item_1309"
                         class="item gp_151">藜麥核桃麵<input type="hidden"
                                                         id="code_1007013"
                                                         value="1007013"
                                                         class="no"></div>
                    <div id="item_1310"
                         class="item gp_151">洋蔥火腿芝士麵<input type="hidden"
                                                           id="code_1007014"
                                                           value="1007014"
                                                           class="no"></div>
                    <div id="item_1311"
                         class="item gp_152">洋蔥火腿鹹芝士條<input type="hidden"
                                                            id="code_1100023"
                                                            value="1100023"
                                                            class="no"></div>
                    <div id="item_1312"
                         class="item gp_154">香草蕃茄薯仔包<input type="hidden"
                                                           id="code_1104012"
                                                           value="1104012"
                                                           class="no"></div>
                    <div id="item_1313"
                         class="item gp_154">藜麥核桃包<input type="hidden"
                                                         id="code_1104013"
                                                         value="1104013"
                                                         class="no"></div>
                    <div id="item_1314"
                         class="item gp_154">洋蔥火腿芝士包<input type="hidden"
                                                           id="code_1104014"
                                                           value="1104014"
                                                           class="no"></div>
                    <div id="item_1315"
                         class="item gp_166">茶葉蛋汁(2斤)<input type="hidden"
                                                            id="code_3002010"
                                                            value="3002010"
                                                            class="no"></div>
                    <div id="item_1316"
                         class="item gp_174">230紙袋(200)<input type="hidden"
                                                              id="code_4202016"
                                                              value="4202016"
                                                              class="no"></div>
                    <div id="item_1317"
                         class="item gp_174">紫薯卷膠盒(25)<input type="hidden"
                                                             id="code_4203020"
                                                             value="4203020"
                                                             class="no"></div>
                    <div id="item_1318"
                         class="item gp_174">2安士芥醬杯 - 淨杯<input type="hidden"
                                                               id="code_4204023"
                                                               value="4204023"
                                                               class="no"></div>
                    <div id="item_1319"
                         class="item gp_174">2安士芥醬杯 - 淨蓋<input type="hidden"
                                                               id="code_4204024"
                                                               value="4204024"
                                                               class="no"></div>
                    <div id="item_1320"
                         class="item gp_174">370ml咖啡樽連蓋(216)<input type="hidden"
                                                                   id="code_4203021"
                                                                   value="4203021"
                                                                   class="no"></div>
                    <div id="item_1321"
                         class="item gp_172">三角茶包 - 四季春(50)<input type="hidden"
                                                                  id="code_4004021"
                                                                  value="4004021"
                                                                  class="no"></div>
                    <div id="item_1322"
                         class="item gp_172">三角茶包 - 白桃烏龍茶(50)<input type="hidden"
                                                                    id="code_4004022"
                                                                    value="4004022"
                                                                    class="no"></div>
                    <div id="item_1323"
                         class="item gp_172">三角茶包 - 凍頂烏龍茶(50)<input type="hidden"
                                                                    id="code_4004023"
                                                                    value="4004023"
                                                                    class="no"></div>
                    <div id="item_1324"
                         class="item gp_172">仙草凍<input type="hidden"
                                                       id="code_4004024"
                                                       value="4004024"
                                                       class="no"></div>
                    <div id="item_1325"
                         class="item gp_172">蜜綠豆<input type="hidden"
                                                       id="code_4004025"
                                                       value="4004025"
                                                       class="no"></div>
                    <div id="item_1326"
                         class="item gp_172">蜜紅豆<input type="hidden"
                                                       id="code_4004026"
                                                       value="4004026"
                                                       class="no"></div>
                    <div id="item_1327"
                         class="item gp_172">芒果爆硃<input type="hidden"
                                                        id="code_4004027"
                                                        value="4004027"
                                                        class="no"></div>
                    <div id="item_1328"
                         class="item gp_172">芒果糖漿<input type="hidden"
                                                        id="code_4004028"
                                                        value="4004028"
                                                        class="no"></div>
                    <div id="item_1329"
                         class="item gp_172">芝麻沙律醬(1.5L)<input type="hidden"
                                                               id="code_4002012"
                                                               value="4002012"
                                                               class="no"></div>
                    <div id="item_1330"
                         class="item gp_167">大魚蛋(1.8kg)<input type="hidden"
                                                              id="code_3004007"
                                                              value="3004007"
                                                              class="no"></div>
                    <div id="item_1334"
                         class="item gp_165">牛肚(3斤)<input type="hidden"
                                                          id="code_3000015"
                                                          value="3000015"
                                                          class="no"></div>
                    <div id="item_1336"
                         class="item gp_172">咖啡糖包(454)<input type="hidden"
                                                             id="code_4002013"
                                                             value="4002013"
                                                             class="no"></div>
                    <div id="item_1337"
                         class="item gp_172">蛋撻王白糖包(424)<input type="hidden"
                                                               id="code_4002014"
                                                               value="4002014"
                                                               class="no"></div>
                    <div id="item_1338"
                         class="item gp_152">鮮奶葡萄<input type="hidden"
                                                        id="code_1100024"
                                                        value="1100024"
                                                        class="no"></div>
                    <div id="item_1339"
                         class="item gp_152">日式松葉蟹柳<input type="hidden"
                                                          id="code_1100025"
                                                          value="1100025"
                                                          class="no"></div>
                    <div id="item_1340"
                         class="item gp_152">芝士鮮奶球<input type="hidden"
                                                         id="code_1100026"
                                                         value="1100026"
                                                         class="no"></div>
                    <div id="item_1341"
                         class="item gp_152">墨西哥藍莓<input type="hidden"
                                                         id="code_1100027"
                                                         value="1100027"
                                                         class="no"></div>
                    <div id="item_1342"
                         class="item gp_152">墨西哥杏仁條<input type="hidden"
                                                          id="code_1100028"
                                                          value="1100028"
                                                          class="no"></div>
                    <div id="item_1343"
                         class="item gp_152">沙律腸仔<input type="hidden"
                                                        id="code_1100029"
                                                        value="1100029"
                                                        class="no"></div>
                    <div id="item_1344"
                         class="item gp_152">紅豆包<input type="hidden"
                                                       id="code_1100030"
                                                       value="1100030"
                                                       class="no"></div>
                    <div id="item_1345"
                         class="item gp_152">蒜蓉包<input type="hidden"
                                                       id="code_1100031"
                                                       value="1100031"
                                                       class="no"></div>
                    <div id="item_1346"
                         class="item gp_152">黑椒香草腸仔包<input type="hidden"
                                                           id="code_1100032"
                                                           value="1100032"
                                                           class="no"></div>
                    <div id="item_1347"
                         class="item gp_152">墨西哥奶皇<input type="hidden"
                                                         id="code_1100033"
                                                         value="1100033"
                                                         class="no"></div>
                    <div id="item_1348"
                         class="item gp_152">菠蘿粒芝士火腿包<input type="hidden"
                                                            id="code_1100034"
                                                            value="1100034"
                                                            class="no"></div>
                    <div id="item_1349"
                         class="item gp_152">牛油椰絲<input type="hidden"
                                                        id="code_1100035"
                                                        value="1100035"
                                                        class="no"></div>
                    <div id="item_1365"
                         class="item gp_172">藜麥碎 (500克)<input type="hidden"
                                                              id="code_4003011"
                                                              value="4003011"
                                                              class="no"></div>
                    <div id="item_1366"
                         class="item gp_172">李錦記甜豉油(12x435g)<input type="hidden"
                                                                   id="code_4002015"
                                                                   value="4002015"
                                                                   class="no"></div>
                    <div id="item_1367"
                         class="item gp_174">個裝包袋(印1色)(200)<input type="hidden"
                                                                  id="code_4202017"
                                                                  value="4202017"
                                                                  class="no"></div>
                    <div id="item_1368"
                         class="item gp_150">牛油餐包麵<input type="hidden"
                                                         id="code_1000004"
                                                         value="1000004"
                                                         class="no"></div>
                    <div id="item_1371"
                         class="item gp_172">蛋黃醬<input type="hidden"
                                                       id="code_4005028"
                                                       value="4005028"
                                                       class="no"></div>
                    <div id="item_1372"
                         class="item gp_176">麵粉袋<input type="hidden"
                                                       id="code_4301014"
                                                       value="4301014"
                                                       class="no"></div>
                    <div id="item_1373"
                         class="item gp_172">方罐餐肉(24x340g)<input type="hidden"
                                                                 id="code_4004029"
                                                                 value="4004029"
                                                                 class="no"></div>
                    <div id="item_1374"
                         class="item gp_172">麻醬(5斤)<input type="hidden"
                                                          id="code_4002016"
                                                          value="4002016"
                                                          class="no"></div>
                    <div id="item_1376"
                         class="item gp_165">牛柳頭片 (2磅)<input type="hidden"
                                                             id="code_300016"
                                                             value="300016"
                                                             class="no"></div>
                    <div id="item_1377"
                         class="item gp_178">影印機碳粉(TN2280)<input type="hidden"
                                                                 id="code_4303012"
                                                                 value="4303012"
                                                                 class="no"></div>
                    <div id="item_1378"
                         class="item gp_178">影印機碳粉(TN2380)<input type="hidden"
                                                                 id="code_4303013"
                                                                 value="4303013"
                                                                 class="no"></div>
                    <div id="item_1379"
                         class="item gp_178">影印機碳粉(TN2480)<input type="hidden"
                                                                 id="code_4303014"
                                                                 value="4303014"
                                                                 class="no"></div>
                    <div id="item_1380"
                         class="item gp_178">Brother 墨水 (BK)<input type="hidden"
                                                                   id="code_4303015"
                                                                   value="4303015"
                                                                   class="no"></div>
                    <div id="item_1381"
                         class="item gp_157">迷你雞批(24件)<input type="hidden"
                                                             id="code_1202002"
                                                             value="1202002"
                                                             class="no"></div>
                    <div id="item_1382"
                         class="item gp_174">蛋撻王貼紙(大)(25張*10個)<input type="hidden"
                                                                     id="code_4201017"
                                                                     value="4201017"
                                                                     class="no"></div>
                    <div id="item_1383"
                         class="item gp_174">蛋撻王貼紙(小)(25張*10個)<input type="hidden"
                                                                     id="code_4201018"
                                                                     value="4201018"
                                                                     class="no"></div>
                    <div id="item_1384"
                         class="item gp_175">酒精搓手液(500ml)<input type="hidden"
                                                                id="code_4300017"
                                                                value="4300017"
                                                                class="no"></div>
                    <div id="item_1385"
                         class="item gp_175">75%酒精(1L)<input type="hidden"
                                                             id="code_4300018"
                                                             value="4300018"
                                                             class="no"></div>
                    <div id="item_1386"
                         class="item gp_179">格仔廚褲(XXXL)<input type="hidden"
                                                              id="code_4304037"
                                                              value="4304037"
                                                              class="no"></div>
                    <div id="item_1388"
                         class="item gp_172">亨氏芥末醬(6p)<input type="hidden"
                                                             id="code_4002017"
                                                             value="4002017"
                                                             class="no"></div>
                    <div id="item_1389"
                         class="item gp_172">百花蜜(1.5kg)<input type="hidden"
                                                              id="code_4002018"
                                                              value="4002018"
                                                              class="no"></div>
                    <div id="item_1390"
                         class="item gp_171">韓式脆熱狗<input type="hidden"
                                                         id="code_4001013"
                                                         value="4001013"
                                                         class="no"></div>
                    <div id="item_1391"
                         class="item gp_176">三層口罩(薄)(50)<input type="hidden"
                                                               id="code_4301015"
                                                               value="4301015"
                                                               class="no"></div>
                    <div id="item_1392"
                         class="item gp_174">透明啡色料10+7*14 雙面印啡(1)<input type="hidden"
                                                                        id="code_4202018"
                                                                        value="4202018"
                                                                        class="no"></div>
                    <div id="item_1393"
                         class="item gp_174">橙色大背心袋(500)<input type="hidden"
                                                               id="code_4202019"
                                                               value="4202019"
                                                               class="no"></div>
                    <div id="item_1394"
                         class="item gp_174">PET- 140*45*40- 白+啡 紙托(50)<input type="hidden"
                                                                              id="code_4202020"
                                                                              value="4202020"
                                                                              class="no"></div>
                    <div id="item_1396"
                         class="item gp_159">蜜瓜牛乳卷<input type="hidden"
                                                         id="code_2003006"
                                                         value="2003006"
                                                         class="no"></div>
                    <div id="item_1397"
                         class="item gp_173">椰絲花生軟糖(20包)<input type="hidden"
                                                               id="code_4100010"
                                                               value="4100010"
                                                               class="no"></div>
                    <div id="item_1398"
                         class="item gp_173">芝麻花生軟糖(20包)<input type="hidden"
                                                               id="code_4100011"
                                                               value="4100011"
                                                               class="no"></div>
                    <div id="item_1399"
                         class="item gp_173">花生酥(20包)<input type="hidden"
                                                            id="code_4100012"
                                                            value="4100012"
                                                            class="no"></div>
                    <div id="item_1400"
                         class="item gp_172">亨氏茄汁小包(100)<input type="hidden"
                                                               id="code_4005029"
                                                               value="4005029"
                                                               class="no"></div>
                    <div id="item_1401"
                         class="item gp_172">家樂牌意式香草<input type="hidden"
                                                           id="code_4005030"
                                                           value="4005030"
                                                           class="no"></div>
                    <div id="item_1402"
                         class="item gp_171">泰式炸魚餅<input type="hidden"
                                                         id="code_4001014"
                                                         value="4001014"
                                                         class="no"></div>
                    <div id="item_1403"
                         class="item gp_173">陳皮燉檸檬燕窩飲(24支)<input type="hidden"
                                                                 id="code_4100013"
                                                                 value="4100013"
                                                                 class="no"></div>
                    <div id="item_1404"
                         class="item gp_173">杞子胎菊燕窩飲(24支)<input type="hidden"
                                                                id="code_4100014"
                                                                value="4100014"
                                                                class="no"></div>
                    <div id="item_1405"
                         class="item gp_171">31/35越南蝦仁(2kgx6)<input type="hidden"
                                                                    id="code_4000006"
                                                                    value="4000006"
                                                                    class="no"></div>
                    <div id="item_1406"
                         class="item gp_173">即食海蜇(麻油味)<input type="hidden"
                                                             id="code_4100015"
                                                             value="4100015"
                                                             class="no"></div>
                    <div id="item_1407"
                         class="item gp_173">紅燒鮑魚4頭<input type="hidden"
                                                          id="code_4100016"
                                                          value="4100016"
                                                          class="no"></div>
                    <div id="item_1408"
                         class="item gp_171">芝士粟米熱狗<input type="hidden"
                                                          id="code_4001015"
                                                          value="4001015"
                                                          class="no"></div>
                    <div id="item_1409"
                         class="item gp_172">大紅浙醋(600ml)<input type="hidden"
                                                               id="code_4002019"
                                                               value="4002019"
                                                               class="no"></div>
                    <div id="item_1410"
                         class="item gp_159">檸檬牛乳卷<input type="hidden"
                                                         id="code_2003007"
                                                         value="2003007"
                                                         class="no"></div>
                    <div id="item_1411"
                         class="item gp_174">13X13開四餐紙<input type="hidden"
                                                             id="code_4204025"
                                                             value="4204025"
                                                             class="no"></div>
                    <div id="item_1412"
                         class="item gp_172">AM朱古力(1kg)<input type="hidden"
                                                              id="code_4005031"
                                                              value="4005031"
                                                              class="no"></div>
                    <div id="item_1413"
                         class="item gp_172">友榮DX抹茶醬(1kg)<input type="hidden"
                                                                id="code_4005032"
                                                                value="4005032"
                                                                class="no"></div>
                    <div id="item_1414"
                         class="item gp_172">月島乳酪(1kg)<input type="hidden"
                                                             id="code_4005033"
                                                             value="4005033"
                                                             class="no"></div>
                    <div id="item_1415"
                         class="item gp_172">藍牛植脂淡奶(400g)<input type="hidden"
                                                                id="code_4004030"
                                                                value="4004030"
                                                                class="no"></div>
                    <div id="item_1416"
                         class="item gp_171">61/70越南蝦仁(2kg/餅)<input type="hidden"
                                                                    id="code_4000007"
                                                                    value="4000007"
                                                                    class="no"></div>
                    <div id="item_1417"
                         class="item gp_181">酥皮原味流心奶皇月餅(12)<input type="hidden"
                                                                  id="code_4102001"
                                                                  value="4102001"
                                                                  class="no"></div>
                    <div id="item_1418"
                         class="item gp_181">雙黃白蓮蓉月餅(12)<input type="hidden"
                                                               id="code_4102002"
                                                               value="4102002"
                                                               class="no"></div>
                    <div id="item_1419"
                         class="item gp_181">蟲草花金腿伍仁月餅(12)<input type="hidden"
                                                                 id="code_4102003"
                                                                 value="4102003"
                                                                 class="no"></div>
                    <div id="item_1420"
                         class="item gp_181">中秋紙袋(225*80*340)(50)<input type="hidden"
                                                                        id="code_4200001"
                                                                        value="4200001"
                                                                        class="no"></div>
                </div>
            </td>
        </tr>
    </table>

    <table class="cssTable3">
        <tr>
            <td class="cssTableInput" style="height:100px;" valign="top">
                <div class="custom">
                    <div class="brand th" valign="center" id="1">
                        <span>蛋撻王 - 香港</span>
                    </div>
                    <div class="brand th" valign="center" id="2">
                        <span>蛋撻王 - 九龍</span>
                    </div>
                    <div class="brand th" valign="center" id="3">
                        <span>蛋撻王 - 新界</span>
                    </div>
                    <div class="brand th" valign="center" id="4">
                        <span>糧友</span>
                    </div>
                    <div class="brand th" valign="center" id="6">
                        <span>共食薈</span>
                    </div>
                    <div class="brand th" valign="center" id="5">
                        <span>貳號冰室</span>
                    </div>
                </div>
                <div style="float:right; color:white; padding:2px;">
                    <input type="checkbox" id="choose_all" checked/>不篩選
                </div>
            </td>
        </tr>
        <tr>
            <td class="cssTableInput" style="height:100px;" valign="top">
                <div class="brand_all" id="brand_all" valign="center" name="">
                    全選
                </div>
                <div class="brand_all" id="brand_all_none" valign="center" name="">
                    全不選
                </div>
            </td>
        </tr>
        <tr>
            <td class="cssTableInput" valign="top">
                <div style="float:left; height:20px; width:30px; background-color:#00356B"></div>
                <span style="float:left; color:white">可選擇</span>
                <div style="float:left; height:20px; width:30px; margin-left:50px; background-color:#717171"></div>
                <span style="color:white">已選擇</span><br><br>

                <div class="custom">
                    <div style="height:461px; overflow:scroll; overflow-y:scroll; overflow-x:hidden;">
                        <div id="38" class="shop area_1 shop_select">
                            蛋撻王(利東街)                            </div>
                        <div id="1" class="shop area_1 shop_select">
                            KB13 蛋撻王(愛東)                            </div>
                        <div id="2" class="shop area_2 shop_select">
                            KB01 蛋撻王(大業)                            </div>
                        <div id="3" class="shop area_2 shop_select">
                            KB02 蛋撻王(宏開)                            </div>
                        <div id="4" class="shop area_2 shop_select">
                            KB03 蛋撻王(宏啟)                            </div>
                        <div id="10" class="shop area_2 shop_select">
                            KB06 蛋撻王(油塘)                            </div>
                        <div id="11" class="shop area_2 shop_select">
                            KB09 蛋撻王(欣榮)                            </div>
                        <div id="13" class="shop area_2 shop_select">
                            KB11 蛋撻王(樂富)                            </div>
                        <div id="12" class="shop area_2 shop_select">
                            KB14 蛋撻王(泓景匯)                            </div>
                        <div id="32" class="shop area_2 shop_select">
                            kb16 蛋撻王(東南樓)                            </div>
                        <div id="34" class="shop area_3 shop_select">
                            B&B01 一口烘焙(長發)                            </div>
                        <div id="14" class="shop area_3 shop_select">
                            KB08 蛋撻王(逸東)                            </div>
                        <div id="15" class="shop area_3 shop_select">
                            KB10 蛋撻王(禾輋)                            </div>
                        <div id="16" class="shop area_3 shop_select">
                            KB12 蛋撻王(新都城II)                            </div>
                        <div id="17" class="shop area_3 shop_select">
                            KB15 蛋撻王(天晉)                            </div>
                        <div id="33" class="shop area_3 shop_select">
                            kb17 蛋撻王(光華)                            </div>
                        <div id="18" class="shop area_4 shop_select">
                            RB01 糧友(荃灣)                            </div>
                        <div id="28" class="shop area_4 shop_select">
                            RB03 糧友(黃埔)                            </div>
                        <div id="29" class="shop area_4 shop_select">
                            RB04 糧友(東港)                            </div>
                        <div id="30" class="shop area_4 shop_select">
                            RB05 糧友(將中)                            </div>
                        <div id="31" class="shop area_4 shop_select">
                            RB06 糧友(YOHO)                            </div>
                        <div id="35" class="shop area_4 shop_select">
                            RB07 糧友(上中)                            </div>
                        <div id="19" class="shop area_4 shop_select">
                            RB08 糧友(MOKO)                            </div>
                        <div id="41" class="shop area_4 shop_select">
                            RB09 糧友(梭椏道)                            </div>
                        <div id="43" class="shop area_4 shop_select">
                            RB10 糧友(奧海城)                            </div>
                        <div id="25" class="shop area_5 shop_select">
                        </div>
                        <div id="26" class="shop area_5 shop_select">
                        </div>
                        <div id="27" class="shop area_5 shop_select">
                        </div>
                        <div id="36" class="shop area_5 shop_select">
                            2cafe01 貳號冰室(華欣樓)                            </div>
                        <div id="9" class="shop area_6 shop_select">
                            CES01 共食薈(開源道)                            </div>
                        <div id="7" class="shop area_6 shop_select">
                            CES02 共食薈(慧霖)                            </div>
                        <div id="24" class="shop area_999 shop_select">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>


</div>

<form action="CMS_order_c_check_save.php" method="POST" id="add_check">
    <input type="hidden" id="type" name="type" value="">
    <input type="hidden" id="action" name="action">
    <input type="hidden" id="report_id" name="report_id">
    <input type="hidden" id="report_info" name="report_info">
</form>

<script>
    $(document).ready(function () {
        $("#title").html("修改報告");

        $(".cssTable2").show();
        $(".cssTable3").hide();

        $("#shop_message").html(_shopMessage());

        //brand//
        $("#custom").change(function () {
            $(".brand").removeClass("brand_select")
        });
        $("#all").change(function () {
            $(".brand").addClass("brand_select")

        });

        $(".brand").click(function () {
            $(".shop").hide();
            $(".area_" + this.id).show();
            $(".brand_all").show();
            $(".brand_all").prop("name", "area_" + this.id);
        });
        $(".brand_all").click(function () {
            $("#choose_all").removeAttr('checked');
            if (this.id == "brand_all") {
                $("." + this.name).addClass("shop_select");
            } else if (this.id == "brand_all_none") {
                $("." + this.name).removeClass("shop_select");
            }

            $("#shop_message").html(_shopMessage());
        });
        $(".shop").click(function () {
            $("#choose_all").removeAttr('checked');
            if ($(this).attr("class").match(/shop_select/g)) {
                $(this).removeClass("shop_select");
            } else {
                $(this).addClass("shop_select");
            }

            var brand_name = this.className.match(/brand_[a-z]+/g);
            var brand = $("." + brand_name).length;
            var selectShop = $("." + brand_name + ".shop_select").length;

            if (brand != selectShop) {
                $("#" + brand_name).removeClass("brand_select");
            } else {
                $("#" + brand_name).addClass("brand_select");
            }

            $("#shop_message").html(_shopMessage());
            //alert($(".shop_select").length);
        });

        $("#choose_all").change(function () {
            if (this.checked) {
                $(".shop").addClass("shop_select");
            }
            $("#shop_message").html(_shopMessage());
        });
        //brand//

        //item//
        $(".cat").click(function () {
            $(".gp").hide();
            $(".gp.cat_" + this.id).show();
        });
        $(".gp").click(function () {
            $(".item").hide();
            $(".item.gp_" + this.id).show();
        });
        $(".item").click(function () {
            //console.log(this.id);
            if ($(this).attr("class").match(/item_selected/g)) {
                $(this).removeClass("item_selected");
                var v = findElementsByName(this.id);
                _deleteRow(v[0]);
                return;
            }

            $(this).addClass("item_selected");
            addToItemList(this);
        });
        //item//
        $(".tab1").click(function () {
            $(".cssTable3").hide();
            $(".cssTable2").show();
            $(".tab2").removeClass("active");
            $(this).addClass("active");
        });
        $(".tab2").click(function () {
            $(".cssTable3").show();
            $(".cssTable2").hide();
            $(".tab1").removeClass("active");
            $(this).addClass("active");
        });

        restoreReportData()
    });

    function _deleteRow(r) {
        $("#" + r.name).removeClass("item_selected");
        var i = r.parentNode.parentNode.rowIndex;

        document.getElementById("item_list").deleteRow(i);
        var v = $("b.count");
        for (i = 0; i < v.length; i++) {
            v[i].innerHTML = i + 1 + ".";
        }
    }

    function _deleteRow2(r) {
        $("#" + r.name).removeClass("shop_select");
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("shop_list").deleteRow(i);
    }

    function _shopMessage() {
        var result = "";
        var shopNum = $(".shop").length;
        var selectNum = $(".shop_select").length;

        if (shopNum == selectNum) {
            result = "已選擇全部分店";
        } else if (selectNum == 0) {
            result = "沒有選擇任何分店";
        } else {
            var c = $(".shop_select");
            result = "<table id='shop_list' style='width:98%'>";
            for (i = 0; i < c.length; i++) {
                result += "<tr>";
                result += "<td>";
                result += c[i].innerHTML + "<br>";
                result += "</td>";
                result += "<td align='right'>";
                result += "<img src='/images/delete.png' style='cursor:pointer;' onclick='_deleteRow2(this)' name='" + c[i].id + "'>";
                result += "</td>";
                result += "</tr>";
            }

            result += "</table>";
        }

        return result;
    }

    function inputChange(s) {
        if (s.value.match(/\D+/g)) {
            s.value = s.value.replace(/\D+/g, "");
        }
    }

    function addToItemList(obj, sort) {
        var s = 1;
        if (sort != null)
            s = sort;

        var count = $("#item_list")[0].rows.length;
        if (count == 0) {
            var r = $("#item_list")[0].insertRow();
            var c1 = r.insertCell(0);
            var c2 = r.insertCell(1);
            var c3 = r.insertCell(2);
            var c4 = r.insertCell(3);

            c1.className = c2.className = c3.className = c4.className = "item_list_th";

            c1.innerHTML = "#";
            c2.innerHTML = "項目";
            c3.innerHTML = "排序";
            c4.innerHTML = "刪除";
            count++;
        }

        var no = $("#" + obj.id + " > .no")[0].value;
        var n = obj.innerHTML.split(/<input/ig)[0];

        var r = $("#item_list")[0].insertRow();
        var c1 = r.insertCell(0);
        var c2 = r.insertCell(1);
        var c3 = r.insertCell(2);
        var c4 = r.insertCell(3);
        c4.className = "item_delete";
        c2.className = "item_list_td";
        c3.className = "item_list_td_1";

        c1.innerHTML = "<b class='count'>" + count + ".</b>";
        c2.innerHTML = n + ", " + no;
        c3.innerHTML = "<input type='text' style='width:50px;' id='sort_" + obj.id + "' value='" + s + "'>";
        c4.innerHTML = "<img src='/images/delete.png' style='cursor:pointer;' onclick='_deleteRow(this)' name='" + obj.id + "'>";

    }

    function search_code(v, e) {
        console.log(e);
        if ((e != null && e.charCode == 13) || e == null) {
            var s = $("#code_" + v)
            var sl = s.length;
            if (sl >= 1 && v != "") {
                var cat = $("#" + s[0].parentNode.className.split(" ")[1].split("_")[1])[0].className.split(" ")[1];
                var gp = s[0].parentNode.className.split(" ")[1].split("_")[1];
                var item = s[0].click();
                $(".gp").hide();
                $(".gp." + cat).show();
                $(".item").hide();
                $(".item.gp_" + gp).show();
            } else {
                alert("沒有找到任何項目");
            }
        }
    }

    function restoreReportData() {
        $("#report_name").val("麵包部 - 生包 - 麵粒、酥")
        $("#num_of_day").val("2")
        $("#sort").val("1")

        if (0 == 0
        )
        {
            $("#hide_f").prop("checked", true);
        }
        if (0 == 0
        )
        {
            $("#main_shop").prop("checked", true);
        }

        var item_id = "item_" + 842 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }
        var item_id = "item_" + 843 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }
        var item_id = "item_" + 844 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }
        var item_id = "item_" + 862 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }
        var item_id = "item_" + 863 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }
        var item_id = "item_" + 1368 ;
        var item = document.getElementById(item_id);
        if (item != null) {
            addToItemList(document.getElementById(item_id), 1);
            $("#" + item_id).addClass("item_selected");
        }



        $(".shop").addClass("shop_select");

        $("#shop_message").html(_shopMessage());
    }

    function submit() {
        if (document.getElementById("report_name").value == "") {
            alert("請輸入報告名稱");
            return;
        }
        if ($(".shop_select").length == 0) {
            alert("請選擇分店");
            return;
        }
        if ($(".item_selected").length == 0) {
            alert("請選擇最少一項項目");
            return;
        }

        document.getElementById('report_id').value = "7";
        document.getElementById('action').value = "update";
        document.getElementById('report_info').value = JSON.stringify(reportInfo());
        //console.log(reportInfo());
        document.getElementById('add_check').submit();
    }

    function reportInfo() {
        var no = [];
        var shop = [];
        var all_shop = 0;
        var all_th = 0;
        var all_tw = 0;
        var all_ctc = 0;
        var all_other = 0;

        var select_item = $(".item_selected");
        var select_shop = $(".shop_select");
        var all_shop = $(".shop");

        var name = document.getElementById("report_name").value;
        var num_of_day = document.getElementById("num_of_day").value;
        var sort = document.getElementById("sort").value;
        //var separate = (document.getElementById("separate_t").checked)? 1 : 0;
        var hide = (document.getElementById("hide_t").checked) ? 1 : 0;
        //var car = (document.getElementById("car_t").checked)? 1 : 0;
        var mainItem = (document.getElementById("main_item").checked) ? 1 : 0;
        //var showNC = (document.getElementById("showNC_t").checked)? 1 : 0;
        var print_weekday = $("#email_weel_val").val();
        ;
        var print_time = $("#email_time").val();


        for (var m = 0; m < select_item.length; m++) {
            var s = select_item[m].id.split("item_")[1];
            s = $("#sort_item_" + s).val() + ":" + s;
            no.push(s);
        }
        if (select_shop.length == all_shop.length) {
            return {
                "item": no,
                "all_shop": 1,
                "name": name,
                "num_of_day": num_of_day,
                "hide": hide,
                "mainItem": mainItem,
                "sort": sort,
                "print_weekday": print_weekday,
                "print_time": print_time
            }
        } else {
            var temp = {
                "item": no,
                "all_shop": 0,
                "name": name,
                "num_of_day": num_of_day,
                "hide": hide,
                "mainItem": mainItem,
                "sort": sort,
                "print_weekday": print_weekday,
                "print_time": print_time
            }
            var list = $(".shop_select");
            for (j = 0; j < list.length; j++)
                shop.push(list[j].id);
            temp.shop = shop;

            return temp;
        }
    }

    Dcat.ready(function () {
        // 写你的逻辑
        Dcat.success('更新成功');
        console.log('sfdsfgdsfd');
    });

</script>

