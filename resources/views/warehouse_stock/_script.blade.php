<script>

    var search_prices;

    //輸入框焦點離開時, 保存已填寫數量
    $(document).on('blur', '.qty, .base_qty', function () {

        let product_id = $(this).data('id');

        let qty =  $(".qty[data-id=" + product_id + "]").val();
        let base_qty =  $(".base_qty[data-id=" + product_id + "]").val();

        submit(qty, base_qty, product_id);

        cal_price(search_prices);

    });

    // $(document).on('keydown', '.qty, .base_qty', function(e) {
    //     if (13 === e.keyCode) {
    //         let product_id = $(this).data('id');
    //
    //         let qty = $(".qty[data-id=" + product_id + "]").val();
    //         let base_qty = $(".base_qty[data-id=" + product_id + "]").val();
    //
    //         submit(qty, base_qty, product_id);
    //
    //         cal_price(search_prices);
    //     }
    // });

    //刪除(x按鈕),刪除庫存
    $(document).on('click', '.delstock', function () {

        let product_id = $(this).data('id');
        let qty_input = $(".qty[data-id=" + product_id + "]");
        let base_qty_input = $(".base_qty[data-id=" + product_id + "]");

        let qty_is_empty = true;
        let base_qty_is_empty = true;

        qty_input.each(function () {

            let input = $(this).val();

            if (input !== null && input !== undefined && input !== "") {
                qty_is_empty = false;
                return false;
            }

        });

        base_qty_input.each(function () {

            let input = $(this).val();

            if (input !== null && input !== undefined && input !== "") {
                base_qty_is_empty = false;
                return false;
            }

        });

        if (qty_is_empty === true && base_qty_is_empty === true) {
            return ;
        }

        $.ajax({
            type: "DELETE",
            url: "{{ route('stock.warehouse.delete', ['date' => request()->date] ) }}",
            data: {
                'product_id': product_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (msg) {
                qty_input.val('');
                base_qty_input.val('');
                cal_price(search_prices);
            },
            error:function () {
                Swal.fire({
                    icon: 'error',
                    title: "發生错误，請嘗試關閉頁面後重新進入",
                });
            }
        });

    });

    //價格千分位用逗號分隔
    function convert_price_to_thousand(price){
        let num = price.toFixed(2) + "";//保留两位小数
        return num.replace(/(\d{1,3})(?=(\d{3})+(?:$|\.))/g,'$1,');
    }

    //計算總價
    function cal_price(prices) {
        let total_price = 0;

        $(".price, .base_price, .subtotal_price").html('');
        $.each(prices, function(key, value) {
            let subtotal_price = 0;
            let price = value.price;
            let base_price = value.base_price;

            let qty =  $(".qty[data-id=" + value.product_id + "]").val();
            let base_qty =  $(".base_qty[data-id=" + value.product_id + "]").val();

            if( qty === null || qty === undefined || qty === ''){
                qty = 0;
            }

            if( base_qty === null || base_qty === undefined || base_qty === '' ){
                base_qty = 0;
            }

            //計算每一行小計
            subtotal_price += parseFloat(qty) * parseFloat(value.price) + parseFloat(base_qty) * parseFloat(value.base_price);
            if (! isNaN(subtotal_price)){
                total_price += parseFloat(subtotal_price);
            }

            $(".price[data-id=" + value.product_id + "]").html('$'+ price + '/');
            $(".base_price[data-id=" + value.product_id + "]").html('$'+ base_price + '/');

            //小計千分位加逗號
            if(subtotal_price > 0){
                let subtotal_price_sum = convert_price_to_thousand(subtotal_price);
                $(".subtotal_price[data-id=" + value.product_id + "]").html('$'+ subtotal_price_sum + '');
            }

            // console.log('qty:' + qty + ',base_qty:' + base_qty
            //     + ',price:' + value.price + ',base_price:' + value.base_price
            //     + ',item_price:' + item_price + ',total_price:' + total_price);

        });

        //總數千分位加逗號
        let total_price_sum = convert_price_to_thousand(total_price);

        $('#total_price').html(total_price_sum);
    }

    //更改日期時
    $(document).on('change', '#invoice_date', function () {
        let date = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ route('stock.warehouse.price_check') }}",
            data: {
                'date': date,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                search_prices = data.prices;
                cal_price(data.prices);
            },
            error:function () {
                Swal.fire({
                    icon: 'error',
                    title: "發生错误，請嘗試關閉頁面後重新進入",
                });
            }
        });


    });

    //提交批次
    function save_invoice(url) {

        let invoice_date = $('#invoice_date').val();
        let invoice_no = $('#invoice_no').val();

        if (invoice_date === null || invoice_date === '') {
            Swal.fire({
                icon: 'error',
                title: "請填寫訂單日期！",
            });
            return;
        }

        if (invoice_no === null || invoice_no === '') {
            Swal.fire({
                icon: 'error',
                title: "請填寫訂單編號！",
            });
            return;
        }

        Swal.fire({
            icon: 'warning',
            title: "確定將所有未保存項目添加到批次?",
            showDenyButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '確定',
            denyButtonText: '取消',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'invoice_no': invoice_no,
                        'date': invoice_date,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (msg) {
                        Swal.fire({
                            icon: 'success',
                            title: "已成功保存到批次",
                        }).then((result) => {
                            window.location.reload();
                        });

                    },
                    error: function (res) {
                        errors = res.responseJSON.errors;
                        let form_errors = '';
                        $.each(errors, function(i) {
                            form_errors += '<div>' + errors[i] + '</div>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: form_errors,
                        });
                    }
                });
            }
        });
    }

</script>
