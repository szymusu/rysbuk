<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            border-spacing: 0;
        }
        td {
            background-color: hotpink;
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body oncontextmenu="return false;">
<script>
    function click(element, button) {
        if (button === 0) {
            element.style.backgroundColor = 'pink'
        }
        else {
            element.style.backgroundColor = 'hotpink'
        }
    }
</script>
    <table>
        <tr>
            <td onmousedown="window.click(this, event.button)"></td>
            <td onmousedown="window.click(this, event.button)"></td>
        </tr>
        <tr>
            <td onmousedown="window.click(this, event.button)"></td>
            <td onmousedown="window.click(this, event.button)"></td>
        </tr>
    </table>

</body>
</html>
