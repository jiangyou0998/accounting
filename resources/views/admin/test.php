<?php

//檢查是否登錄,是否管理員
// require("check_login.php");


$timestamp = gettimeofday("sec");

$showDate = "";

$today = date('Y-m-d', $timestamp);
IF ($showDate == "") $showDate = $today;

// var_dump($showDate);

$shopArray = [
    'b&b01' =>  '一口烘焙(長發)',
    'ces01' =>  '共食薈(開源道)',
    'ces02' =>  '共食薈(慧霖)',
    'kb01'  =>  '蛋撻王(大業)',
    'kb02'  =>  '蛋撻王(宏開)',
    'kb03'  =>  '蛋撻王(宏啟)',
    'kb06'  =>  '蛋撻王(油塘)',
    'kb08'  =>  '蛋撻王(逸東)',
    'kb09'  =>  '蛋撻王(欣榮)',
    'kb10'  =>  '蛋撻王(禾輋)',
    'kb11'  =>  '蛋撻王(樂富)',
    'kb12'  =>  '蛋撻王(新都城II)',
    'kb13'  =>  '蛋撻王(愛東)',
    'kb14'  =>  '蛋撻王(泓景匯)',
    'kb15'  =>  '蛋撻王(天晉)',
    'kb16'  =>  '蛋撻王(東南樓)',
    'kb17'  =>  '蛋撻王(光華)',
    'kb18'  =>  '蛋撻王(利東街)',
];




?>


<form action="#" method="post" name="frmcheck">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="middle">
                日期:
                <input type="text" name="checkDate" class="form-control" value="<?= $showDate ?>" id="datepicker"
                       onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>

                <input type="submit" name="Submit" value="查詢"/>
            </td>
        </tr>
        <tr>
            <td align="center"></td>
        </tr>
    </table>
</form>
<br/>
<br/>

<div align="center" width="100%">
    <div align="center" style="width:850px;">
        <h1>下單統計</h1>


        <table class="cssTable1" id="table1">
            <tr class="cssImportant">
                <th style="width:50px;">#</th>
                <th style="width:80px;">賬號</th>
                <th style="width:200px;">分店名</th>
                <th style="width:150px;">送貨日期</th>
                <th style="width:150px;">下單項目數量</th>
            </tr>

            <?php
            $count = 1;
            foreach ($shopArray as $key => $value) { ?>
                <?php $s = Array('否', '是'); ?>
                <?php if ($count % 2 == 1) { ?>
                    <tr>
                <?php } else { ?>
                    <tr bgcolor="#DDDDDD">
                <?php } ?>
                <td><?= $count ?></td>
                <!--                賬號-->
                <td><?= is_array($value) ? $value['shop_accout'] : $key ?></td>
                <!--                分店名-->
                <td><?= is_array($value) ? $value['shop_name'] : $value ?></td>
                <!--                送貨日期-->
                <td><?= is_array($value) ? $value['deli_date'] : '/' ?></td>
                <!--                下單項目數量-->
                <td><?= is_array($value) ? $value['item_count'] : '/' ?></td>
                </tr>

                <?php

                $count++;

            } ?>

        </table>


