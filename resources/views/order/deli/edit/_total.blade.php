{{--        總價--}}
        <table class="table1" border="1" cellspacing="0" cellpadding="0"
               style="width:995px; margin:auto; margin-left:1%;">
            <tr>
                <td width="575px" align="left" bgcolor="#CCFFFF">&nbsp;&nbsp;
                    <span style="font-size:24px; font-weight:bold;">總數: $
					<span id="all_total">{{number_format($total_price, 1, '.', ',')}}</span>
				</span>

                    <div style="color:red">
                        &nbsp;&nbsp;

                        第一車:$<span class="dept-total" data-dept="A"
                                 data-sum="{{$dept_price['A']}}">{{number_format($dept_price['A'], 1, '.', ',')}}</span>
                        第二車:$<span class="dept-total" data-dept="B"
                                 data-sum="{{$dept_price['B']}}">{{number_format($dept_price['B'], 1, '.', ',')}}</span>
                        麵頭:$<span class="dept-total" data-dept="C"
                                 data-sum="{{$dept_price['C']}}">{{number_format($dept_price['C'], 1, '.', ',')}}</span>
{{--                        樓:$<span class="dept-total" data-dept="F"--}}
{{--                                 data-sum="{{$dept_price['F']}}">{{number_format($dept_price['F'], 1, '.', ',')}}</span>--}}
                    </div>
                </td>
                <td width="194px" align="center" bgcolor="#CCFFFF"></td>
                <td width="200px" align="center" bgcolor="#CCFFFF"></td>
            </tr>
        </table>
