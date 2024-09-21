$(document).ready(function() {
    $('.add-btn').click(function() {
        const number = $(this).data('number');
        updateOrderAmount(number, 'add');
    });

    $('.clear-btn').click(function() {
        const number = $(this).data('number');
        updateOrderAmount(number, 'clear');
    });

    function updateOrderAmount(number, action) {
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: { number: number, action: action },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {                    
                    let orderElement = $('#order-' + number);
                    let newOrderAmount = res.data[0]['orderamount'];
                    orderElement.text(newOrderAmount);
                }
            }
        });
    }

    // // Handle "Update" button click
    // $('#update-btn').click(function() {
    //     $.ajax({
    //         url: 'index.php',
    //         type: 'POST',
    //         data: { action: 'data-update' },
    //         success: function(response) {
    //             const res = JSON.parse(response);
    //             if (res.status === 'success') {
    //                 alert('Data successfully updated from Excel!');
    //                 location.reload();
    //             } else {
    //                 alert('Failed to update data.');
    //             }
    //         }
    //     });
    // });

    $(".btn-update").click(function() {
        $("#updateForm").append("<img src='./assets/images/loading.gif'>");
    });
});
