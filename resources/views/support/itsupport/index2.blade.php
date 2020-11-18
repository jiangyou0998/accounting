@extends('layouts.app')

@section('content')

    <style type="text/css">
        body, td, th {
            font-size: small;
        }

        input[disabled] {
            background-color: #7F7F7F !important;
        }
    </style>
    <script type="text/javascript" src="/js/jquery-1.4.1.js"></script>
    <script type="text/javascript" src="/js/wbox-min.js"></script>
    <script type="text/javascript" src="/LawEnforcementRecords/js/fbw-ajax.js"></script>
    <script type="text/javascript" src="/js/overlib.js"></script>
    <link href="/wbox/wbox.css" rel="stylesheet" type="text/css"/>
    <style>
        <!--
        #wBoxContent > iframe {
            width: 500px !important;
            height: 600px !important;
        }

        -->
    </style>
    <script type="text/javascript">

        function confInsertSubmit() {
            document.getElementById("insertSubmit").disabled = true;


            var checkType = true;
            if ($('#inputDate').val() == '') {
                alert('請選擇日期！');
                $('#inputDate').focus();
                document.getElementById("insertSubmit").disabled = false;
                return false;
            }
            if (document.getElementById('sel_Impo').selectedIndex == 0) {
                alert('請選擇「緊急性」選項');
                document.getElementById("insertSubmit").disabled = false;
                return false;
            }


            if (document.getElementById('sel_project_type').selectedIndex == 0) {

                alert('請選擇「位置」選項');
                document.getElementById("insertSubmit").disabled = false;
                return false;
            }

            if (document.getElementById('sel_project').selectedIndex == 0) {

                alert('請選擇「維修項目」選項');
                document.getElementById("insertSubmit").disabled = false;
                return false;
            }

            if (document.getElementById('sel_help').selectedIndex == 0) {
                checkType = false;
            }

            if (!checkType) {

                checkType = true;
                if ($("#textarea").val() == "") {
                    checkType = false;
                }

            }

            if (!checkType) {
                alert('請選擇「求助事宜」或「其他資料提供」選項！');
                document.getElementById("insertSubmit").disabled = false;
                return false
            }


            var answer = confirm("確認提交資料?(如有文件檔，按\"是\"後請耐心等待)");
            if (!answer) {
                document.getElementById("insertSubmit").disabled = false;
                return false;
            }
        }

        function upFile(btnId) {
            if (document.getElementById('uploadfile[]').value != '')
                document.getElementById('btnFile' + btnId).style.backgroundColor = "#00FF00";
            return false;
        }

        function clearFileInputField(tagId) {
            document.getElementById('div_file' + tagId).innerHTML = document.getElementById('div_file' + tagId).innerHTML;
            document.getElementById('btnFile' + tagId).style.backgroundColor = "";
        }


        /*新加入 2015 01 05*/
        function SelProject_Type() {
            $.ajax({
                type: "post",
                url: "itsupport.php",
                data: "submit=project&pid=" + $("#sel_project_type").val(),
                success: function (data) {
                    $("#sel_project").empty();
                    $(data).appendTo("#sel_project");
                },
                error: function (resp) {
                    console.log(resp);
                }
            });
        }

        function SelCheng(obj) {
            if ($(obj).val() == "2") {
                $("#sellogistics").show();
                $("#branch").hide();
            } else {
                $("#sellogistics").hide();
                $("#branch").show();
            }

            $.ajax({
                type: "post",
                url: "itsupport.php",
                data: "submit=project_type&pid=" + $(obj).val(),
                success: function (data) {
                    $("#sel_project_type").empty();
                    $(data).appendTo("#sel_project_type");
                },
                error: function (resp) {
                    console.log(resp);
                }
            });
        }

        function _func_delete(id, code) {
            var answer = confirm("確定取消編號為【" + code + "】的維修項目嗎？");
            if (!answer) {
                return false;
            } else {
                var data = {action: 'delete', id: id};
                $.post('itsupport.php', data, function (resp) {
                    alert("求助已刪除！");
                    location.reload();
                });
            }
        }

        function _func_show(id, type) {
            var title = type == 1 ? "未完成處理" : "最近14天內完成處理之申請";
            var wBox = $("#look")
                .wBox({
                    requestType: "iframe",
                    title: title,
                    width: 200,
                    height: 50,
                    target: "itsupport_handle.php?id=" + id + "&type=" + type
                });
            wBox.showBox();
        }

    </script>


<script>
    function redirectPage(redirPage) {
//		alert('hello');
        if (redirPage == 'order.php?head=5')
            parent.location.href = redirPage
    }

    function ImgOver(op, num) {
        op.src = "images/Header_d_" + num + ".jpg";
    }

    function ImgOut(op, num) {
        op.src = "images/Header_" + num + ".jpg";
    }

    function ImgOver_a(op, num) {
        op.src = "images/Head_d_" + num + ".jpg";
    }

    function ImgOut_a(op, num) {
        op.src = "images/Head_" + num + ".jpg";
    }
</script>

<!--
<map name="Map" id="Map"><area shape="rect" coords="836,42,981,115" href="http://www.taihingroast.com/" target="_blank" alt="�ӿ�����" />
	<area shape="rect" coords="170,0,834,126" href="index.php" alt="�ӿ����p��" />
	<area shape="rect" coords="5,27,166,101" href="http://intranet.taihingroast.com.cn" target="_blank" />
</map>
-->

<div id="popupPanel" style="display: none;">
    <div class="popup" name="__popup" onMouseOut="exitPanel(event)">
        <table cellspacing="0" width="222px" height="120px" cellpadding="0" border="0" background="images/order_bg.jpg"
               style="background-repeat:no-repeat">
            <tr>
                <td class="description" width="230px"
                    style="padding: 5px; padding-left:8px;padding-top:8px;vertical-align: top;">
                    <span style="font-size:15px; color:#000;">p{chr_remarks}</span>
                </td>
                <td width="5px" style="padding: 5px;padding-top:8px;padding-left:0px;  vertical-align: bottom;">
                    <a style="border: none;" href="javascript:void(0)" onClick="nd();">
                        <img style="border: none;" src="images/close.gif"/>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>

<div align="center" style="width:994px">
    <h1><u>IT維修項目</u></h1>
</div>
<div align="center" style="width:994px">
    <h2>新輸入</h2>
</div>

<form enctype="multipart/form-data" name="form_CaseInsert" id="form" action="itsupport.php" method="post"
      onSubmit="return confInsertSubmit();">

    <table border="1" style="border-collapse:collapse;" borderColor="#ccc" cellspacing="0" cellpadding="0"
           width="994px">


        <tr>
            <td align="center" bgcolor="#CCFFFF" width="10%">日期</td>
            <td align="center" bgcolor="#CCFFFF" width="10%">分店/部門</td>
            <td align="center" bgcolor="#CCFFFF" width="8%">緊急性</td>
            <td align="center" bgcolor="#CCFFFF" width="9%">器材</td>
            <td align="center" bgcolor="#CCFFFF" width="9%">求助事宜</td>
            <td align="center" bgcolor="#CCFFFF" width="10%">機器號碼#</td>
            <td align="center" bgcolor="#CCFFFF" width="13%">其他資料提供</td>
            <td align="center" bgcolor="#CCFFFF" width="12%">上傳文檔(如有)</td>
            <td align="center" bgcolor="#CCFFFF" width="10%">&nbsp;</td>
        </tr>
        <tr>
            <td height="30" align="center">2020-11-12</td>
            <td height="30" align="center">測試店</td>
            <td height="30" align="center" valign="middle">
                <select name="sel_Impo" id="sel_Impo" style="width: 95%">
                    <option value="0">請選擇</option>
                    <option value="3">高</option>
                    <option value="4">中</option>
                    <option value="5">低</option>
                </select>
            </td>
            <td height="30" align="center" valign="middle">
                <select name="sel_project_type" id="sel_project_type" style="width: 95%" onChange="SelProject_Type();">
                    <option value="0">請選擇</option>
                    <option value='1'>收銀機 POS1</option><option value='15'>落單機POS2</option><option value='16'>落單機POS3</option><option value='7'>CCTV</option><option value='18'>伺服器SERVER</option><option value='12'>電腦列印機</option><option value='14'>拍卡機</option><option value='4'>Fax/Scanner</option><option value='9'>叫飛系統</option><option value='3'>廚房印機</option><option value='5'>PDA</option><option value='2'>iPad</option><option value='6'>TV</option><option value='8'>顯示屏</option><option value='19'>UPS後備電</option><option value='20'>器材回廠維修</option><option value='17'>唔著</option><option value='21'>餐牌</option><option value='11'>電腦部件訂購</option><option value='10'>其他</option><option value='22'>其他硬件問題</option>                </select>
            </td>
            <td height="30" align="center" valign="middle">
                <select name="sel_project" id="sel_project" style="width: 95%" onChange="SelProject();">
                    <option value="0">請選擇</option>
                </select>
            </td>


            <td height="30" align="center"><input type="text" name="txt_number" id="txt_number" style="width:90%"/></td>


            <td height="30" align="center">
                <table width="100%" height="100%">
                    <tr>
                        <td width="50%"><textarea name="textarea" id="textarea"
                                                  style="height: 98%; width: 90%"></textarea></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td align="right" bgcolor="#EEEEEE">
                            <div id="div_file1" style="position: relative">
                                <input id="uploadfile[]" onChange="upFile('1')" name="uploadfile[]" type="file"
                                       style="position:absolute;filter:alpha(opacity=0);  -moz-opacity:0;         /*火狐*/opacity:0;  width:50px;"/>
                                <input type="button" id="btnFile1" name="btnFile1" style="width:50px" value="相片1"/>
                            </div>
                        </td>
                        <td align="left" bgcolor="#EEEEEE">
                            <input type="button" id="clear1" name="clear1" onClick="clearFileInputField('1');"
                                   value="清除"/>
                        </td>
                    </tr>
                </table>
            </td>
            <td height="30" align="center">
                <input name="submit" value="輸入" type="hidden"/>
                <input id="insertSubmit" type="submit" value="輸入" style="background-color:green;color:white;"/>
            </td>
        </tr>
    </table>
</form>

<br>
<br>

<div align="center" style="width:994px">
    <h2>未完成處理</h2>
</div>
<form name="form_CaseUpdate" id="form2" action="itsupport.php" method="post">


    <table width="994px" border="1" style="border-collapse:collapse;" borderColor="#ccc" cellspacing="0"
           cellpadding="0">
        <input type="hidden" id="updateID" name="updateID" value=""/>
        <tr bgcolor="#CCFFFF">

            <td align="center" width="3%"><b>#</b></td>
            <td align="center" width="6%"><b>編號</b></td>

            <td align="center" width="10%"><b>完成日期</b></td>

            <td align="center" width="8%"><b>分店/部門</b></td>
            <td align="center" width="5%"><b>緊急性</b></td>
            <td align="center" width="12%"><b>器材</b></td>
            <td align="center" width="14%"><b>求助事宜</b></td>
            <td align="center" width="7%"><b>#機器號碼</b></td>
            <td align="center" width="10%"><b>其他資料提供</b></td>
            <td align="center" width="6%"><b>上傳文檔</b></td>


            <td align="center" width="18%"><b></b></td>


        </tr>


        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>1</b></td>
            <td align="center">18IT0098</td>
            <td align="center" height="25">
                2020-11-12                    (<font color="red">0</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('98', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('98', '18IT0098');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>2</b></td>
            <td align="center">18IT0070</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">顯示屏</td>
            <td align="center">無顯示</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('70', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('70', '18IT0070');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>3</b></td>
            <td align="center">18IT0069</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS2</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('69', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('69', '18IT0069');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>4</b></td>
            <td align="center">18IT0068</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">低                </td>
            <td align="center">落單機POS2</td>
            <td align="center">小露寶</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('68', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('68', '18IT0068');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>5</b></td>
            <td align="center">18IT0067</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('67', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('67', '18IT0067');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>6</b></td>
            <td align="center">18IT0066</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS3</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('66', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('66', '18IT0066');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>7</b></td>
            <td align="center">18IT0065</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">餐牌錯</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('65', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('65', '18IT0065');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>8</b></td>
            <td align="center">18IT0064</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('64', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('64', '18IT0064');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>9</b></td>
            <td align="center">18IT0063</td>
            <td align="center" height="25">
                2020-09-10                    (<font color="red">63</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">餐牌錯</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('63', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('63', '18IT0063');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>10</b></td>
            <td align="center">18IT0055</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS3</td>
            <td align="center">唔著</td>

            <td align="center">123 </td>
            <td chr_remarks='23123213'
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
                2312321...                </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('55', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('55', '18IT0055');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>11</b></td>
            <td align="center">18IT0054</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS3</td>
            <td align="center">右上角出現紅X(斷線)</td>

            <td align="center">0</td>
            <td chr_remarks='0001給你個'
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
                0001給你dasdsadasdasdsadasdsa...                </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('54', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('54', '18IT0054');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>12</b></td>
            <td align="center">18IT0053</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">CCTV</td>
            <td align="center">不停地出聲</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('53', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('53', '18IT0053');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>13</b></td>
            <td align="center">18IT0052</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">CCTV</td>
            <td align="center">有CAM唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('52', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('52', '18IT0052');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>14</b></td>
            <td align="center">18IT0051</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">右上角出現紅X(斷線)</td>

            <td align="center">111</td>
            <td chr_remarks='111'
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
                111                </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('51', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('51', '18IT0051');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>15</b></td>
            <td align="center">18IT0050</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">Touch問題(好難Touch)</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('50', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('50', '18IT0050');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>16</b></td>
            <td align="center">18IT0049</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('49', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('49', '18IT0049');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>17</b></td>
            <td align="center">18IT0048</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS3</td>
            <td align="center">右上角出現紅X(斷線)</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('48', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('48', '18IT0048');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>18</b></td>
            <td align="center">18IT0047</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">低                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('47', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('47', '18IT0047');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>19</b></td>
            <td align="center">18IT0046</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS3</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('46', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('46', '18IT0046');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>20</b></td>
            <td align="center">18IT0045</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('45', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('45', '18IT0045');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>21</b></td>
            <td align="center">18IT0044</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS3</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('44', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('44', '18IT0044');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>22</b></td>
            <td align="center">18IT0043</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('43', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('43', '18IT0043');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>23</b></td>
            <td align="center">18IT0042</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('42', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('42', '18IT0042');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>24</b></td>
            <td align="center">18IT0041</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS3</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('41', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('41', '18IT0041');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>25</b></td>
            <td align="center">18IT0040</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS2</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('40', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('40', '18IT0040');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>26</b></td>
            <td align="center">18IT0039</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">落單機POS2</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('39', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('39', '18IT0039');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>27</b></td>
            <td align="center">18IT0038</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">低                </td>
            <td align="center">落單機POS2</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('38', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('38', '18IT0038');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>28</b></td>
            <td align="center">18IT0037</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">伺服器SERVER</td>
            <td align="center">其他</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('37', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('37', '18IT0037');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>29</b></td>
            <td align="center">18IT0036</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">伺服器SERVER</td>
            <td align="center">出品部全部冇飛出</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('36', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('36', '18IT0036');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>30</b></td>
            <td align="center">18IT0035</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">落單機POS3</td>
            <td align="center">右上角出現紅X(斷線)</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('35', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('35', '18IT0035');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>31</b></td>
            <td align="center">18IT0034</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">電腦列印機</td>
            <td align="center">列印唔到野</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('34', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('34', '18IT0034');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>32</b></td>
            <td align="center">18IT0033</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">餐牌</td>
            <td align="center">餐牌錯</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('33', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('33', '18IT0033');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>33</b></td>
            <td align="center">18IT0032</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">低                </td>
            <td align="center">收銀機 POS1</td>
            <td align="center">印表機問題</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('32', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('32', '18IT0032');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>34</b></td>
            <td align="center">18IT0031</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">伺服器SERVER</td>
            <td align="center">其他</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('31', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('31', '18IT0031');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>35</b></td>
            <td align="center">18IT0030</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">低                </td>
            <td align="center">電腦列印機</td>
            <td align="center">唔著</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('30', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('30', '18IT0030');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#DDDDDD">
            <td rowspan="1" align="center"><b>36</b></td>
            <td align="center">18IT0029</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">高                </td>
            <td align="center">iPad</td>
            <td align="center">上唔到網</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#DDDDDD">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('29', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('29', '18IT0029');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>

        <tr bgcolor="#ffffff">
            <td rowspan="1" align="center"><b>37</b></td>
            <td align="center">18IT0028</td>
            <td align="center" height="25">
                2020-09-07                    (<font color="red">66</font>)
            </td>
            <td align="left" height="25">測試店</td>
            <td align="center">中                </td>
            <td align="center">廚房印機</td>
            <td align="center">其他</td>

            <td align="center"></td>
            <td chr_remarks=''
                onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
                target="leftFrame">
            </td>
            <td bgcolor="#ffffff">
                <table>
                    <tr></tr>


                </table>
            </td>

            <td align="center" style="padding:5px;">
                <button type="button" onclick="_func_show('28', '1')"
                        style="background-color:#ADFFAD;">補充資料
                </button>


                <button type="button" onclick="_func_delete('28', '18IT0028');"
                        style="background-color:#FFADAD;">刪除
                </button>
            </td>

        </tr>
    </table>
</form>

<br>
<br>

<div align="center" style="width:994px">
    <h2>最近14天內完成處理之申請</h2>
</div>



<table width="994px" border="1" style="border-collapse:collapse;" borderColor="#ccc" cellspacing="0"
       cellpadding="0">

    <tr bgcolor="#CCFFFF">

        <td align="center" width="3%"><b>#</b></td>
        <td align="center" width="6%"><b>編號</b></td>

        <td align="center" width="10%"><b>完成日期</b></td>

        <td align="center" width="8%"><b>分店/部門</b></td>
        <td align="center" width="5%"><b>緊急性</b></td>
        <td align="center" width="8%"><b>維修項目</b></td>
        <td align="center" width="10%"><b>求助事宜</b></td>
        <td align="center" width="7%"><b>#機器號碼</b></td>
        <td align="center" width="10%"><b>其他資料提供</b></td>
        <td align="center" width="6%"><b>上傳文檔</b></td>


        <td align="center" width="18%"><b></b></td>


    </tr>

    <tr bgcolor="#ffFFFF">
        <td rowspan="1" align="center" style="padding:5px;"><b>1</b></td>
        <td align="center">18IT0071</td>
        <td align="center" height="25">
            2020-09-10                    (<font color="red">63</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">中                </td>
        <td align="center">落單機POS2</td>
        <td align="center">唔著</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#ffFFFF">
            <table>
                <tr>                        </tr>
            </table>
        </td>
        <td align="center" style="padding:5px;">
            <button type="button" onclick="_func_show('71', '2')"
                    style="background-color:#FFFFAD;">跟進資料
            </button>
        </td>
    </tr>

    <tr bgcolor="#DDDDDD">
        <td rowspan="1" align="center" style="padding:5px;"><b>2</b></td>
        <td align="center">18IT0072</td>
        <td align="center" height="25">
            2020-09-10                    (<font color="red">63</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">中                </td>
        <td align="center">落單機POS2</td>
        <td align="center">唔著</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#DDDDDD">
            <table>
                <tr>                        </tr>
            </table>
        </td>
        <td align="center" style="padding:5px;">
            <button type="button" onclick="_func_show('72', '2')"
                    style="background-color:#FFFFAD;">跟進資料
            </button>
        </td>
    </tr>

    <tr bgcolor="#ffFFFF">
        <td rowspan="1" align="center" style="padding:5px;"><b>3</b></td>
        <td align="center">18IT0077</td>
        <td align="center" height="25">
            2020-09-10                    (<font color="red">63</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">中                </td>
        <td align="center">落單機POS3</td>
        <td align="center">印表機問題</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#ffFFFF">
            <table>
                <tr>                        </tr>
            </table>
        </td>
        <td align="center" style="padding:5px;">
            <button type="button" onclick="_func_show('77', '2')"
                    style="background-color:#FFFFAD;">跟進資料
            </button>
        </td>
    </tr>
</table>


<br>
<br>

<div align="center" style="width:994px">
    <h2>最近14天內<font color="red">取消</font>之申請</h2>
</div>


<table width="994px" border="1" style="border-collapse:collapse;" borderColor="#ccc" cellspacing="0"
       cellpadding="0">
    <tr bgcolor="#CCFFFF">
        <td align="center" width="3%"><b>#</b></td>
        <td align="center" width="6%"><b>編號</b></td>

        <td align="center" width="10%"><b>取消日期</b></td>

        <td align="center" width="8%"><b>分店/部門</b></td>
        <td align="center" width="5%"><b>緊急性</b></td>
        <td align="center" width="8%"><b>維修項目</b></td>
        <td align="center" width="10%"><b>求助事宜</b></td>
        <td align="center" width="7%"><b>#機器號碼</b></td>
        <td align="center" width="10%"><b>其他資料提供</b></td>
        <td align="center" width="6%"><b>上傳文檔</b></td>

    </tr>



    <tr bgcolor="#ffFFFF">
        <td rowspan="1" align="center" style="padding:5px;"><b>1</b></td>
        <td align="center">18IT0027</td>
        <td align="center" height="25">
            2020-09-07                        (<font color="red">66</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">中                    </td>
        <td align="center">落單機POS3</td>
        <td align="center">中間出現紅色視窗</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#ffFFFF">
            <table>
                <tr>                            </tr>
            </table>
        </td>
    </tr>

    <tr bgcolor="#DDDDDD">
        <td rowspan="1" align="center" style="padding:5px;"><b>2</b></td>
        <td align="center">18IT0026</td>
        <td align="center" height="25">
            2020-09-07                        (<font color="red">66</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">高                    </td>
        <td align="center">落單機POS2</td>
        <td align="center">右上角出現紅X(斷線)</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#DDDDDD">
            <table>
                <tr>                            </tr>
            </table>
        </td>
    </tr>

    <tr bgcolor="#ffFFFF">
        <td rowspan="1" align="center" style="padding:5px;"><b>3</b></td>
        <td align="center">18IT0025</td>
        <td align="center" height="25">
            2020-09-07                        (<font color="red">66</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">高                    </td>
        <td align="center">落單機POS2</td>
        <td align="center">中間出現紅色視窗</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#ffFFFF">
            <table>
                <tr>                            </tr>
            </table>
        </td>
    </tr>

    <tr bgcolor="#DDDDDD">
        <td rowspan="1" align="center" style="padding:5px;"><b>4</b></td>
        <td align="center">18IT0024</td>
        <td align="center" height="25">
            2020-09-07                        (<font color="red">66</font>)
        </td>
        <td align="left" height="25">測試店</td>
        <td align="center">高                    </td>
        <td align="center">CCTV</td>
        <td align="center">收銀位沒顯示</td>

        <td align="center"></td>
        <td chr_remarks=''
            onMouseOver="var _a = popupPanel(this); overlib(_a,FULLHTML,HAUTO,OFFSETX, 0,OFFSETY, -10,FOLLOWMOUSE,'off');"
            target="leftFrame">
        </td>
        <td bgcolor="#DDDDDD">
            <table>
                <tr>                            </tr>
            </table>
        </td>
    </tr>
</table>


<br>
<br>
<br>
<br>
<br>
<br>

<table width="994" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><img src="images/TaiHing_23.jpg" width="994" height="49"></td>
    </tr>
</table>
<script src="My97DatePicker/WdatePicker.js"></script>
<script>
    $(function () {

        $('#sel').change(function () {

            window.location = 'itsupport.php?sel=' + $(this).val();
        });
    });
</script>




@endsection
