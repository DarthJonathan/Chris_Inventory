import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Axios from 'axios';
import Select from 'react-select';
import DatePicker from 'react-datepicker';

class NewTaxInvoiceForm extends Component {

    constructor(props) {
        super(props);

        this.state={
            customers:[],
            date: new Date()
        }
    }

    componentWillMount() {
        Axios.get('/api/v1/customers')
            .then(res => {
                return res.data;
            })
            .then(data => {
                let options = [];

                Promise.all(data.map(item => {
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
            })
            .catch(err => {
                alert(err);
            });

        this.handleChangeDate = this.handleChangeDate.bind(this);
    }

    handleChangeDate(e) {
        this.setState({
            date: e
        });
    }

    render() {
        return (<div>
            <div className="form-group row">
                <label htmlFor="date" className="col-sm-3 col-form-label">Invoice No</label>
                <div className="col-sm-9">
                    <input type="text" className="form-control" id="invoiceno" name="invoiceno"
                           placeholder="Enter Invoice No"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="date" className="col-sm-3 col-form-label">Month</label>
                <div className="col-sm-9">
                    <DatePicker
                        name="date"
                        id="date"
                        className="form-control"
                        selected={this.state.date}
                        onChange={this.handleChangeDate}
                        dateFormat="MMMM yyyy"
                        showMonthYearPicker
                    />
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="price" className="col-sm-3 col-form-label">Customer(Optional)</label>
                <div className="col-sm-9">
                    <Select options={this.state.customers} name="customer" id="customer"/>
                </div>
            </div>

            <div className="form-group row">
                <label htmlFor="date" className="col-sm-3 col-form-label">Cashed</label>
                <div className="col-sm-9">
                    <div className="form-check d-flex">
                        <input type="radio" name="cashed" id="cashed_true" value="true" className="form-check-input"/>
                        <label htmlFor="cashed_true" className="form-check-label">Cashed</label>
                    </div>
                    <div className="form-check d-flex">
                        <input type="radio" name="cashed" id="cashed_false" value="false" className="form-check-input"/>
                        <label htmlFor="cashed_false" className="form-check-label">Not Cashed Yet</label>
                    </div>
                </div>
            </div>
        </div>);
    }
}

if (document.getElementById('newTaxInvoiceComponent')) {
    ReactDOM.render(<NewTaxInvoiceForm/>, document.getElementById('newTaxInvoiceComponent'));
}