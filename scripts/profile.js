function Sell(t_id) {
    $.ajax({
        url: "/php/sell.php",
        type: "POST",
        data: {
            id: t_id
        },
        success: (data) => {
            if (data == 'ok')
                $('#ticket' + t_id).html('<td colspan="5" class="td">Билет продан.</td>');
            else 
                alert(data);
        }
    });
}