$(document).ready(function() {
    $('.minusbtn').click(function() {
        $eachPrice = Number($(this).parents("tr").find('#price').text().replace('Kyats', ''));
        $eachQty = Number($(this).parents("tr").find('#quantity').val());

        $totalPrice = $eachPrice * $eachQty;

        $(this).parents("tr").find('#calPrice').text($totalPrice + 'Kyats');
        allTotal()
    });
    $('.plusbtn').click(function() {
        $eachPrice = Number($(this).parents("tr").find('#price').text().replace('Kyats', ''));
        $eachQty = Number($(this).parents("tr").find('#quantity').val());
        $totalPrice = $eachPrice * $eachQty;
        $(this).parents("tr").find('#calPrice').text($totalPrice + 'Kyats');
        allTotal()
    })
    $('.remove').click(function() {
        $(this).parents('tr').remove();
        allTotal()
    });

    function allTotal() {
        $subTotal = 0
        $('#table').find('tbody tr').each(function(index, tr) {
            $subTotal += Number($(tr).find('#calPrice').text().replace('Kyats', ''));
        });
        $('#totalPrice').text($subTotal);
        $('#finalPrice').text(($subTotal + 3000) + "Kyats")
    }

})
