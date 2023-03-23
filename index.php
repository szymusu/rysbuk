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
<body oncontextmenu="return false" ondragstart="return false">
<script>

    const mouseButtonState = [false, false, false]
    let bold = true
    let width

    function squareMouseOver(element) {
        const affected = [element]
        if (bold) {
            affected.push(document.getElementById((parseInt(element.id) - 1).toString()))
            affected.push(document.getElementById((parseInt(element.id) + 1).toString()))
            affected.push(document.getElementById((parseInt(element.id) - width).toString()))
            affected.push(document.getElementById((parseInt(element.id) - width + 1).toString()))
            affected.push(document.getElementById((parseInt(element.id) - width - 1).toString()))
            affected.push(document.getElementById((parseInt(element.id) + width).toString()))
            affected.push(document.getElementById((parseInt(element.id) + width + 1).toString()))
            affected.push(document.getElementById((parseInt(element.id) + width - 1).toString()))
        }
        const filtered = affected.filter((e) => !(parseInt(element.id) % width === width-1 && parseInt(e.id) % width === 0
                              || parseInt(element.id) % width === 0 && parseInt(e.id) % width === width-1))

        if (mouseButtonState[0]) {
            filtered.forEach((e) => e.style.backgroundColor = "pink")
        }
        else if (mouseButtonState[2]) {
            filtered.forEach((e) => e.style.backgroundColor = "hotpink")
        }
    }

    function createSquare(index) {
        const element = document.createElement("td")
        element.id = index
        element.onmouseover = () => squareMouseOver(element)
        return element
    }

    function createRow(length, rowIndex) {
        const row = document.createElement("tr")
        row.id = `row-${rowIndex}`
        for (let i = 0; i < length; i++) {
            row.appendChild(createSquare(rowIndex*length + i))
        }
        return row
    }

    function createTable(tableElement, rows, columns) {
        width = columns
        for (let i = 0; i < rows; i++) {
            tableElement.appendChild(createRow(columns, i))
        }
    }

    function main() {
        const tableElement = document.querySelector("table#canvas")
        createTable(tableElement, 50, 50)
        tableElement.onmousedown = (event) => mouseButtonState[event.button] = true
        tableElement.onmouseup = (event) => mouseButtonState[event.button] = false
    }

</script>
    <table id="canvas"></table>

    <script>
        window.main()
    </script>
</body>
</html>
