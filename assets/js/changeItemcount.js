function changeItemcount(inputId, operator) {
    var itemcount = parseInt(document.getElementById(inputId).value);

    if (operator === '-') {
        if (itemcount > 0) {
            document.getElementById(inputId).value = itemcount - 1;
        }
    }
    if (operator === '+') {
        if (itemcount < 99) {
            document.getElementById(inputId).value = itemcount + 1;
        }
    }
}