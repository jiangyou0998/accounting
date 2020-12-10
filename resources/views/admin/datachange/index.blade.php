<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page Expired</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

<body>
<div class="flex-center position-ref full-height">
    <form id="notice" method="POST" action="/admin/data/test">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <button id="submit">更改數據</button>
    </form>

    <form id="form" method="POST" action="/admin/data/form">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <button id="submit">更改表格</button>
    </form>
</div>



<script type="text/javascript">

</script>
</body>

</html>
