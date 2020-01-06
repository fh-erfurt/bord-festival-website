function changeTicketcount(inputId, operator) {
    var ticketcount = parseInt(document.getElementById(inputId).value);

    if (operator === '-') {
        if (ticketcount > 0) {
            document.getElementById(inputId).value = ticketcount - 1;
        }
    }
    if (operator === '+') {
        if (ticketcount < 99) {
            document.getElementById(inputId).value = ticketcount + 1;
        }
    }
}