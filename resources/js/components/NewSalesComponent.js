import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Axios from 'axios';
import Select from 'react-select';

export default class NewSalesComponent extends Component {

    constructor(props) {
        super(props);

        this.state = {
            products: [],
            items: 1
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
            })
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
                    <label htmlFor="date" className="col-sm-3 col-form-label">Date*</label>
                    <div className="col-sm-9">
                        <input type="date" className="form-control " id="date" name="sales_date" placeholder="Enter date"/>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="price" className="col-sm-3 col-form-label">Item*</label>
                    <div className="col-sm-9">
                        <input type="num" step="1" min="1" className="form-control" id="item" name="product_id"
                               placeholder="Item"/>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="price" className="col-sm-3 col-form-label">Price per Item*</label>
                    <div className="col-sm-9">
                        <input type="num" step="0.1" min="0" className="form-control" id="price" name="itemprice"
                               placeholder="Price"/>
                    </div>
                </div>

                <div className="form-group row">
                    <label htmlFor="price" className="col-sm-3 col-form-label">Discount*</label>
                    <div className="col-sm-9">
                        <input type="num" step="0.1" min="0" className="form-control" id="discount" name="discount"
                               placeholder="Discount"/>
                    </div>
                </div>

                <div className="row">
                    <div className="col-lg-12">
                        <hr/>
                    </div>
                </div>


                <div className="form-group row">
                    <h4>Existing Tax Invoice</h4>
                </div>

                <div className="form-group row">
                    <label htmlFor="price" className="col-sm-3 col-form-label">Tax Invoice*</label>
                    <div className="col-sm-9">
                        <input type="num" step="1" min="1" className="form-control" id="item" name="tax_invoice_id"
                               placeholder="Item"/>
                    </div>
                </div>

                <div className="form-group row">
                    <h4>New Tax Invoice</h4>
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
