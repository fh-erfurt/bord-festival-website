function changeTicketcount(operator)
{
    var ticketcount = parseInt(document.getElementById("ticketcount").value);

    if(operator === '-')
    {
        if(ticketcount > 0)
        {
            document.getElementById("ticketcount").value = ticketcount - 1;
        }
    }
    if(operator === '+')
    {
        if(ticketcount < 99)
        {
            document.getElementById("ticketcount").value = ticketcount + 1;
        }
    }
}