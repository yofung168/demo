<html>
<head>
    <title>demo实例</title>
</head>
<body>
    <form id="demo" action="" method="post">
        {{ csrf_field() }}
        <input type="text" name="code" value="" placeholder="输入授权码" />
        <button type="submit">确定</button>
    </form>
</body>
</html>