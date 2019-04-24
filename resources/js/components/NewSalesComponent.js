import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Axios from 'axios';
import Select from 'react-select';

export default class NewSalesComponent extends Component {

    constructor(props) {
        super(props);

        this.state = {
            products: [],
            tax_invoice: [],
            items: 1,
            customers: []
        }
    }

    componentDidMount() {

        Axios.get('/api/v1/products')
            .then(res => {
                return res.data;
            })
            .then(data => {
                let options = [];

                Promise.all(data.map(item => {
                    options.push({
                        label: item.product_name,
                        value: item.id
                    });
                }))
                    .then(() => {
                        this.setState({
                            products: options
                        })
                    })
            })
            .catch(err => {
                alert(err);
            });

        Axios.post('/api/v1/tax_invoices')
            .then(res => {
                return res.data;
            })
            .then(data => {
                let options = [];

                Promise.all(data.map(item => {
                    options.push({
                        label: item.invoice_no,
                        value: item.id
                    });
                }))
                    .then(() => {
                        this.setState({
                            tax_invoice: options
                        })
                    })
            })
            .catch(err => {
                alert(err);
            });

        Axios.get('/api/v1/customers')
            .then(res => {
                return res.data;
            })
            .then(res => {
                let options = [];

                Promise.all(res.map(item => {
                    options.push({
                        label: item.name,
                        value: item.id
                    });
                }))
                    .then(() => {
                        this.setState({
                            customers: options
                        })
                    })
            });
    }

    renderProducts() {

        const items = (key) =>  <div key={key}>
            <div className="row">
                <div className="col-lg-12">
                    <hr/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Item*</label>
                <div className="col-sm-9">
                    <Select options={this.state.products} name="item[]" id="item"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Item Quantity*</label>
                <div className="col-sm-9">
                    <input type="num" step="1" min="0" className="form-control" id="quantity" name="quantity[]"
                           placeholder="Quantity"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Price per Item*</label>
                <div className="col-sm-9">
                    <input type="num" step="0.1" min="0" className="form-control" id="price" name="price[]"
                           placeholder="Price"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Discount*</label>
                <div className="col-sm-9">
                    <input type="num" step="0.1" min="0" className="form-control" id="discount" name="discount[]"
                           placeholder="Discount"/>
                </div>
            </div>
        </div>;

        let items_ = [];

        for(var i = 0; i<this.state.items; i++){
            items_.push(items(i));
        }

        return items_;
    }

    render() {
        return (
            <div>
                <div className="form-group row">
                    <label htmlFor="date" className="col-sm-3 col-form-label">Sale Date*</label>
                    <div className="col-sm-9">
                        <input type="date" className="form-control " id="date" name="sales_date" placeholder="Enter date"/>
                    </div>
                </div>

                {this.renderProducts()}

                <div className="row">
                    <div className="col-lg-12">
                        <div className="float-right">
                            <button className="btn btn-primary" type="button" onClick={() => {
                                this.setState({
                                    items: this.state.items+1
                                });
                            }}>Add New Item</button>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-lg-12">
                        <hr/>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="customer" className="col-sm-3 col-form-label">Customer*</label>
                    <div className="col-sm-9">
                        <Select options={this.state.customers} name="customer_id" id="customer"/>
                    </div>
                </div>

                <div className="row">
                    <div className="col-lg-12">
                        <hr/>
                    </div>
                </div>


                <div className="form-group row">
                    <div className="col-12">
                        <h4>Existing Tax Invoice</h4>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="price" className="col-sm-3 col-form-label">Tax Invoice*</label>
                    <div className="col-sm-9">
                        <Select options={this.state.tax_invoice} name="tax_invoice_id" id="tax_invoice"/>
                    </div>
                </div>

                <div className="form-group row">
                    <div className="col-lg-12">
                        <h4>New Tax Invoice</h4>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="invoicenumber" className="col-sm-3 col-form-label">Tax Invoice</label>
                    <div className="col-sm-9">
                        <input type="text" className="form-control" id="taxinvoice" name="taxinvoice" placeholder="Tax Invoice"/>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="invoicenumber" className="col-sm-3 col-form-label">Tax Invoice Date</label>
                    <div className="col-sm-9">
                        <input type="text" className="form-control" id="date_2" name="taxinvoicedate"
                               placeholder="Tax Invoice Date"/>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('newSalesComponent')) {
    ReactDOM.render(<NewSalesComponent/>, document.getElementById('newSalesComponent'));
}
