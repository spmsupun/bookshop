import React from 'react';
import {makeStyles} from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import Chip from '@material-ui/core/Chip';
import IconButton from '@material-ui/core/IconButton';
import DeleteIcon from '@material-ui/icons/Delete';
const axios = require('axios').default;

const useStyles = makeStyles({
    table: {
        minWidth: 700,
    },
});

function ccyFormat(num) {
    return `${num.toFixed(2)}`;
}

function priceRow(qty, unit) {
    return qty * unit;
}

function createRow(id, desc, category, qty, unit) {
    const price = priceRow(qty, unit);
    return {id, desc, category, qty, unit, price};
}

let rows = [];
let invoiceSubtotal;
let invoiceDiscount;
let invoiceTotal;


export default function Invoice(props) {
    const classes = useStyles();
    rows = [];

    props.invoice.items.map((item) => {
        rows.push(createRow(item.book.id, item.book.name, item.book.category, item.quantity, item.book.price));
    });

    invoiceSubtotal = props.invoice.price.sub_total;
    invoiceDiscount = props.invoice.price.discount_amount;
    invoiceTotal = props.invoice.price.total;

    let removeCartItem = (bookId) => {
        axios.post('/cart/item/remove', {
            book_id: bookId
        }).then((response) => {
            props.refresh();

        }).catch((error) => {
        });
    };

    return (
        <TableContainer component={Paper}>
            <Table className={classes.table} aria-label="spanning table">
                <TableHead>
                    <TableRow>
                        <TableCell align="center" colSpan={3}>
                            Details
                        </TableCell>
                        <TableCell align="right">Price</TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell>Desc</TableCell>
                        <TableCell align="right">Qty.</TableCell>
                        <TableCell align="right">Unit</TableCell>
                        <TableCell align="right">Sum</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {rows.map(row => (
                        <TableRow key={row.desc}>
                            <TableCell>
                                <IconButton aria-label="delete" className={classes.margin}
                                            onClick={() => removeCartItem(row.id)}>
                                    <DeleteIcon fontSize="small"/>
                                </IconButton>{row.desc} <Chip label={row.category}/></TableCell>
                            <TableCell align="right">{row.qty}</TableCell>
                            <TableCell align="right">{row.unit}</TableCell>
                            <TableCell align="right">{ccyFormat(row.price)}</TableCell>
                        </TableRow>
                    ))}

                    <TableRow>
                        <TableCell rowSpan={3}/>
                        <TableCell colSpan={2}>Subtotal</TableCell>
                        <TableCell align="right">{ccyFormat(invoiceSubtotal)}</TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell>Discount</TableCell>
                        <TableCell align="right" color={'#ccc'}>({props.invoice.price.added_discounts})</TableCell>
                        <TableCell align="right">{ccyFormat(invoiceDiscount)}</TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell colSpan={2}>Total</TableCell>
                        <TableCell align="right">{ccyFormat(invoiceTotal)}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </TableContainer>
    );
}
