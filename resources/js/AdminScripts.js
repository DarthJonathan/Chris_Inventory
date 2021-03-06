var taxInvoiceTable;
var customerTable;
var bsCustomFileInput = require('bs-custom-file-input');

$(document).ready(function() {
    bsCustomFileInput.init();
    //Product page
    var productsTable = $('#productsOverview').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'product_name'},
            {'data': 'description'},
            {'data': 'stock'},
            {
                'data': 'queue',
                render: function (data, type, row) {
                    if(data == null) {
                        return 'Rp. 0,00';
                    }else {
                        return 'Rp.' + numeral(data.price/1.1).format('0,0.00');
                    }
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.queue == null ? 0 : row.queue.price,
                        'quantity': row.stock
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral(data.price/1.1 * data.quantity).format('0,0.00');
                }
            },
            {
                'data': null,
                render: function (data, type, row) {
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

    $('#productsOverview tbody').on('click', 'button', function () {
        var data = productsTable.row($(this).parents('tr')).data();
        var type = $(this).data('type');

        if (type === "edit") {
            window.location.href = '/products/edit/' + data.id;
        } else {
            axios.post('/products/delete', qs.stringify({id: data.id}))
                .then(res => {
                    return res.data;
                })
                .then(res => {
                    if (res.success === true) {
                        productsTable.ajax.reload();
                    } else {

                    }
                    console.log(res);
                });
        }

    });

    //Purchases Table
    var purchasesTable = $('#purchasesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'invoice_id'},
            {
                'data': 'tax_invoice_id',
                render: function (data, type, row) {
                    if (data === null)
                        return 'None';
                    else
                        return data;
                }
            },
            {'data': 'transaction_date'},
            {
                'data': null,
                render: function (data, type, row) {
                    return '<button class="btn btn-primary mr-2 edit-product" data-type="details">' +
                            '<i class="icon-info"></i>' +
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

    $('#purchasesTable tbody').on('click', 'button', function () {
        var data = purchasesTable.row($(this).parents('tr')).data();
        var type = $(this).data('type');

        if (type === "edit") {
            window.location.href = '/purchases/edit/' + data.id;
        } else if (type === "details") {
            window.location.href = '/purchases/details/' + data.id;
        } else {
            axios.post('/purchases/delete', qs.stringify({id: data.id}))
                .then(res => {
                    return res.data;
                })
                .then(res => {
                    if (res.success === true) {
                        purchasesTable.ajax.reload();
                    } else {
                        alert('Deleting error!');
                    }
                });
        }
    });

    //Imported data table
    var importedData = $('#uploadedReportTable').DataTable();

    //Sales Table
    var salesTable = $('#salesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'invoice_id'},
            {
                'data': 'transaction_date',
                render: (data) => {
                    return moment(data).format("DD MMMM YYYY");
                }
            },
            {
                'data': 'tax_invoice_id',
                render: function (data, type, row) {
                    if (data === null)
                        return 'None';
                    else
                        return data;
                }
            },
            {
                'data': 'sales.id',
                render: function (data, type, row) {
                    return '<button class="btn btn-primary mr-2 edit-product" data-type="details">' +
                        '<i class="icon-info"></i>' +
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
        "ajax": "/sales/datatables"
    });

    $('#salesTable tbody').on('click', 'button', function () {
        var data = salesTable.row($(this).parents('tr')).data();
        var type = $(this).data('type');

        if (type === "edit") {
            window.location.href = '/sales/edit/' + data.id;
        } else if (type === "details") {
            window.location.href = '/sales/details/' + data.id;
        } else {
            axios.post('/sales/delete', qs.stringify({id: data.id}))
                .then(res => {
                    return res.data;
                })
                .then(res => {
                    if (res.success === true) {
                        salesTable.ajax.reload();
                    } else {
                        console.log(res);
                        alert('Deleting error!');
                    }
                });
        }
    });

    // Tax Invoices Table
    taxInvoiceTable = $('#taxInvoiceTable').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            {'data': 'invoice_no'},
            {
                'data': 'date',
                render: (data) => {
                    return moment(data).format("MMMM YYYY");
                }
            },
            {
                data: 'used',
                render: (data) => {
                    if (data) {
                        return '<span>Used</span>';
                    } else {
                        return '<span>Not Used</span>';
                    }
                }
            },
            {
                data: 'id',
                render: (data) => {
                    return '<a href="/taxinvoices/details/' + data + '" class="btn btn-primary mr-2 edit-product">' +
                        'Details' +
                        '</a>';
                }
            }
        ],
        "ajax": "/taxinvoices/datatables"
    });

    // Tax Invoices Table
    customerTable = $('#customerTable').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            {data: 'id'},
            {data: 'name'},
            {data: 'phone'},
            {data: 'email'},
            {data: 'details'},
            {
                data: 'id',
                render: (data) => {
                    return '<a href="/customers/details/' + data + '" class="btn btn-primary mr-2 edit-product">' +
                        'Details' +
                        '</a>';
                }
            }
        ],
        "ajax": "/api/v1/customers_datatables"
    });

    //Yearly report table
    yearlyReportTable = $('#yearlyReportTable').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "columns": [
            {
                data: 'date',
                render: (data) => {
                    return moment(data).format("LLLL")
                }
            },
            {
                data: 'invoice_id'
            },
            {
                data: 'product_name'
            },
            {
                data: 'quantity'
            },
            {
                data: 'price',
                render: (data) => {
                    return 'Rp.' + numeral(data).format('0,0.00');
                }
            },
            {
                data: 'discount',
                render: (data) => {
                    return 'Rp.' + numeral(data).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral((data.price - data.discount) * data.quantity).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral(parseFloat(((data.price - data.discount) * data.quantity)/1.1).toFixed(0)).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral(parseFloat(((data.price - data.discount) * data.quantity) - (((data.price - data.discount) * data.quantity)/1.1)).toFixed(0)).format('0,0.00');
                }
            },
            {
                data: 'tax_invoice.tax_invoice_no',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return data;
                    }
                }
            },
            {
                data: 'tax_invoice.date',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return data;
                    }
                }
            },
            {
                data: 'tax_invoice.credited_date',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return moment(data).format("LLLL");
                    }
                }
            },
        ],
        "ajax": "/report/yearly/datatables/" + $("#yearlyReportTable").data('type') + "/" + $("#year").val()
    });

    $("#year").change(() => {
        yearlyReportTable
                .ajax
                .url("/report/yearly/datatables/" + $("#yearlyReportTable").data('type') + "/" + $("#year").val())
                .load();

        $('#export-excel').attr('href', '/report/export/yearly/' + $('#export-excel').data('type') + '/' + $('#year').val());
    });

    if($('#year')) {
        let yearNow = new Date().getFullYear();
        for(var i=yearNow-1; i>yearNow-5; i--)
            $('#year').append('<option value="' + i + '">' + i + '</option>');
    }

    //Monthly report table
    monthlyReportTable = $('#monthlyReportTable').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "columns": [
            {
                data: 'date',
                render: (data) => {
                    return moment(data).format("LLLL")
                }
            },
            {
                data: 'invoice_id'
            },
            {
                data: 'product_name'
            },
            {
                data: 'quantity'
            },
            {
                data: 'price',
                render: (data) => {
                    return 'Rp.' + numeral(data).format('0,0.00');
                }
            },
            {
                data: 'discount',
                render: (data) => {
                    return 'Rp.' + numeral(data).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral((data.price - data.discount) * data.quantity).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral(parseFloat((data.price - data.discount) * data.quantity)/1.1.toFixed(0)).format('0,0.00');
                }
            },
            {
                data: ( row, type, set, meta ) => {
                    return {
                        'price': row.price,
                        'discount': row.discount,
                        'quantity': row.quantity
                    }
                },
                render: (data) => {
                    return 'Rp.' + numeral(parseFloat((data.price - data.discount) * data.quantity) - (((data.price - data.discount) * data.quantity)/1.1).toFixed(0)).format('0,0.00');
                }
            },
            {
                data: 'tax_invoice.tax_invoice_no',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return data;
                    }
                }
            },
            {
                data: 'tax_invoice.date',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return data;
                    }
                }
            },
            {
                data: 'tax_invoice.credited_date',
                render: (data) => {
                    if(data === null) {
                        return 'N/A';
                    }else {
                        return moment(data).format("LLLL");
                    }
                }
            },
        ],
        "ajax": "/report/monthly/datatables/" + $("#monthlyReportTable").data('type') + "/" + $("#month").val()
    });

    $("#month").change(() => {
        monthlyReportTable
            .ajax
            .url("/report/monthly/datatables/" + $("#monthlyReportTable").data('type') + "/" + $("#month").val())
            .load();

        $('#export-excel').attr('href', '/report/export/monthly/' + $('#export-excel').data('type') + '/' + $('#month').val());
    });

    if($('#month')) {
        let yearNow = new Date().getFullYear();
        let monthNow = new Date().getMonth();
        for(var i=0; i<12; i++) {
            if(i != monthNow)
                $('#month').append('<option value="' + i + '">' + monthNames(i) + " " + yearNow + '</option>');
        }
    }
});

/**
 * Deletes tax invoice
 * @param id
 */
function deleteTaxInvoice(id) {
    axios.post('/taxinvoices/delete', qs.stringify({id : id}))
        .then(res => {
            return res.data;
        })
        .then(res => {
            if(res.success === true) {
                taxInvoiceTable.ajax.reload();
            }else {

            }
            console.log(res);
        });
}

/**
 * Gets the month name from a month number
 * @param monthNumber
 */
function monthNames(monthNumber) {
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    return (monthNames[monthNumber])
}

window.deleteTaxInvoice = deleteTaxInvoice;
