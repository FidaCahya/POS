function modalAction(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('#myModal').html(response).modal('show');
        },
        error: function() {
            alert('Gagal memuat data');
        }
    });
}
