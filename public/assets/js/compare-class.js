$('.ajax-compare').on('click', function (e) {
    e.preventDefault();

    var $link = $(this);
    var productId = $link.data('compare-product-id');
    var actionUrl = $link.data('compare-action');
    var method = $link.data('compare-method');

    $.ajax({
        url: actionUrl,
        type: method,
        data: {
            product_id: productId,
        },
        dataType: 'json'
    })
        .done(function (response) {
            // Expecting response in format: { type: 'success'|'warning', message: '...' }
            if(response.type === 'success'){
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Warning!',
                    text: response.message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        })
        .fail(function (xhr, status, error) {
            // If there's a server or network error, try to extract the JSON message if exists
            var errorMsg = 'An error occurred while processing your request.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire({
                title: 'Error!',
                text: errorMsg,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
});
