$(document).ready(function() {
    //Product page
    var productsTable = $('#productsOverview').DataTable( {
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'product_name'},
            {'data': 'description'},
            {'data': 'stock'},
            {
                'data': 'queue.price',
                render: function(data, type, row) {
                    return 'Rp.' + data + ',00';
                }
            },
            {
                'data': null,
                render : function(data, type, row) {
                    return '<button class="btn btn-primary mr-2 edit-product" data-type="edit">' +
                        '<i class="icon-pencil"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger delete-product" data-type="delete">' +
                        '<i class="icon-trash"></i>' +
                        '</button>'
                }
            },
        ],
        "ajax": "/products/datatables"
    });

    $('#productsOverview tbody').on('click', 'button', function() {
        var data = productsTable.row( $(this).parents('tr') ).data();
        var type = $(this).data('type');

        if(type === "edit") {
            window.location.href = '/products/edit/' + data.id;
        }else{
            axios.post('/products/delete', qs.stringify({id : data.id}))
                .then(res => {
                    return res.data;
                })
                .then(res => {
                    if(res.success === true) {
                        productsTable.ajax.reload();
                    }else {
                        
                    }
                    console.log(res);
                });
        }

    });

    //Purchases Table
    var purchasesTable = $('#purchasesTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'invoice_id'},
            {
                'data': 'tax_invoice_id',
                render: function(data,type,row) {
                    if(data === null)
                        return 'None';
                    else
                        return data;
                }
            },
            {'data': 'transaction_date'},
            {
                'data': null,
                render : function(data, type, row) {
                    return '<button class="btn btn-primary mr-2 edit-product" data-type="edit">' +
                        'Details' +
                        '</button>' +
                        '<button class="btn btn-primary mr-2 edit-product" data-type="edit">' +
                        '<i class="icon-pencil"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger delete-product" data-type="delete">' +
                        '<i class="icon-trash"></i>' +
                        '</button>'
                }
            },
        ],
        "ajax": "/purchases/datatables"
    });

    $('#purchasesTable tbody').on('click', 'button', function() {
        var data = productsTable.row( $(this).parents('tr') ).data();
        var type = $(this).data('type');

        if(type === "edit") {
            window.location.href = '/products/edit/' + data.id;
        }else{
            axios.post('/products/delete', qs.stringify({id : data.id}))
                .then(res => {
                    return res.data;
                })
                .then(res => {
                    if(res.success === true) {
                        productsTable.ajax.reload();
                    }else {

                    }
                    console.log(res);
                });
        }

    });

});