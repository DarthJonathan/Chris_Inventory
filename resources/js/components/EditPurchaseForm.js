import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Axios from 'axios';
import Select from 'react-select';

class EditPurchaseForm extends Component {

    constructor(props) {
        super(props);

        this.state = {
            item: window.items,
            products: [],
            items: window.items.length,
            additional: 0
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

    handleChange(e, key) {
        let old = this.state.item;

        old[key] = {
            ...old[key],
            [e.target.id]: e.target.value
        };

        console.log(old);

        this.setState({
            item: old
        });
    }

    renderProducts() {
        const items = (key, item) => <div key={key}>
            <div className="row">
                <div className="col-lg-12">
                    <hr/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Item*</label>
                <div className="col-sm-9">
                    <Select options={this.state.products} name="item[]" id="item" value={{label: item.product.product_name, value: item.product_id}}/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Item Quantity*</label>
                <div className="col-sm-9">
                    <input type="num" step="1" min="0" onChange={(e) => this.handleChange(e, key)} value={item.quantity} className="form-control" id="quantity" name="quantity[]"
                           placeholder="Quantity"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Price per Item*</label>
                <div className="col-sm-9">
                    <input type="num" step="0.1" min="0" onChange={(e) =>  this.handleChange(e, key)} value={item.price} className="form-control" id="price" name="price[]"
                           placeholder="Price"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Discount*</label>
                <div className="col-sm-9">
                    <input type="num" step="0.1" min="0" onChange={(e) =>  this.handleChange(e, key)} value={item.discount} className="form-control" id="discount" name="discount[]"
                           placeholder="Discount"/>
                </div>
            </div>
        </div>;

        let items_ = [];

        if(this.state.items > 0)
            this.state.item.map((item, count) => {
                items_.push(items(count, item))
            });

        return items_;
    }

    renderNewProducts() {
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

        for(var i = 0; i<this.state.additional; i++){
            items_.push(items(i));
        }

        return items_;
    }

    render() {
        console.log(this.state);
        return (
            <div>

                {this.renderProducts()}
                {this.renderNewProducts()}

                <div className="row">
                    <div className="col-lg-12">
                        <div className="float-right">
                            <button className="btn btn-primary" type="button" onClick={() => {
                                this.setState({
                                    additional: this.state.additional+1
                                });
                            }}>Add New Item</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('editPurchaseForm')) {
    ReactDOM.render(<EditPurchaseForm/>, document.getElementById('editPurchaseForm'));
}
