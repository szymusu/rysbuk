const mouseButtonState = [false, false, false]
let bold = true
let width
let height
const colors = ["white", "black", "red", "blue", "green", "yellow"]
let colorIndex = 1

function squareMouseOver(element) {
    const id = parseInt(element.id)
    const affectedIds = [id]
    if (bold) {
        if (id % width !== 0){
            affectedIds.push(id - 1 - width)
            affectedIds.push(id - 1)
            affectedIds.push(id - 1 + width)
        }
        if (id % width !== width - 1){
            affectedIds.push(id + 1 - width)
            affectedIds.push(id + 1)
            affectedIds.push(id + 1 + width)
        }
        affectedIds.push(id + width)
        affectedIds.push(id - width)
    }

    let colorToSet = 0
    if (mouseButtonState[0]) colorToSet = colorIndex
    else if (!mouseButtonState[2]) return

    for (let i = 0; i < affectedIds.length; i++) {
        if (affectedIds[i] >= 0 && affectedIds[i] < width * height) {
            const e = document.getElementById(affectedIds[i].toString())
            e.style.backgroundColor = colors[colorToSet]
            e.colorIndex = colorToSet
        }
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

function toggleBold(element) {
    if (bold) {
        bold = false
        element.className = ""
    }
    else {
        bold = true
        element.className = "white-on-black"
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
    createTable(tableElement, 30, 30)
    tableElement.onmousedown = (event) => mouseButtonState[event.button] = true
    tableElement.onmouseup = (event) => mouseButtonState[event.button] = false

    const colorPickerElement = document.querySelector("div#color-picker")
    createColorPicker(colorPickerElement)
}

main()