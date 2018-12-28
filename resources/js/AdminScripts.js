$(document).ready(function() {
    $('#productsOverview').DataTable( {
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'product_name'},
            {'data': 'description'},
            {'data': 'stock'},
            {'data': 'queue.price'},
            {
                'data': null,
                'defaultContent' : '<button>Click</button>'
            },
        ],
        "ajax": "/products/datatables"
    } );
} );