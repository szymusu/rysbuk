<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>rysb.uk</title>
    <style>
        table#canvas {
            border-spacing: 0;
            border: solid black 2px;
        }
        td {
            width: 20px;
            height: 20px;
        }

        .fl {
            float: left;
        }

        .select-color {
            width: 50px;
            height: 50px;
            margin: 10px;
        }
    </style>
</head>
<body oncontextmenu="return false" ondragstart="return false">
<script>

    const mouseButtonState = [false, false, false]
    let bold = true
    let width
    let height
    const colors = ["white", "black", "red", "blue", "green", "yellow"]
    let colorIndex = 1

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
            filtered.forEach((e) => {
                e.style.backgroundColor = colors[colorIndex]
                e.colorIndex = colorIndex
            })
        }
        else if (mouseButtonState[2]) {
            filtered.forEach((e) => {
                e.style.backgroundColor = colors[0]
                e.colorIndex = 0
            })
        }
    }

    function createSquare(index) {
        const element = document.createElement("td")
        element.id = index
        element.onmouseover = () => squareMouseOver(element)
        element.onmousedown = () => setTimeout(() => squareMouseOver(element), 1)
        element.colorIndex = 0
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
        height = rows
        for (let i = 0; i < rows; i++) {
            tableElement.appendChild(createRow(columns, i))
        }
    }

    function createSelectColor(index) {
        const element = document.createElement("div")
        element.className = "select-color"
        element.style.backgroundColor = colors[index]
        element.onclick = () => colorIndex = index
        return element
    }

    function createColorPicker(colorPickerElement) {
        for (let i = 1; i < colors.length; i++) {
            colorPickerElement.appendChild(createSelectColor(i))
        }
    }

    function encodeBoard() {
        const array = new Uint8Array(width*height / 2)
        for (let i = 0; i < width*height; i += 2) {
            const leftNibble = document.getElementById(i.toString()).colorIndex
            const rightNibble = document.getElementById((i+1).toString()).colorIndex
            array[i/2] = leftNibble*16 + rightNibble
        }
        return array
    }

    function main() {
        const tableElement = document.querySelector("table#canvas")
        createTable(tableElement, 50, 50)
        tableElement.onmousedown = (event) => mouseButtonState[event.button] = true
        tableElement.onmouseup = (event) => mouseButtonState[event.button] = false

        const colorPickerElement = document.querySelector("div#color-picker")
        createColorPicker(colorPickerElement)
    }

</script>
    <table id="canvas" class="fl"></table>
    <div id="color-picker" class="fl"></div>

    <script>
        window.main()
    </script>
</body>
</html>
