import React, {useEffect} from 'react';
import Books from './Books';
import Navbar from './Navbar';
import {LinearProgress} from '@material-ui/core';
import BottomNavigation from '@material-ui/core/BottomNavigation';
import BottomNavigationAction from '@material-ui/core/BottomNavigationAction';
import ImportContactsIcon from '@material-ui/icons/ImportContacts';
import LocalLibraryIcon from '@material-ui/icons/LocalLibrary';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import Invoice from './Invoice';

const axios = require('axios').default;


export default function Home(props) {
    const [bookList, setBooks] = React.useState([]);
    const [cart, setCart] = React.useState([]);
    const [invoice, setInvoice] = React.useState(false);
    const [loader, setLoader] = React.useState(false);
    const [invoiceStatus, showInvoice] = React.useState(false);
    const [couponStatus, showCoupon] = React.useState(false);
    const [couponCode, setCoupon] = React.useState(false);
    const [invalidCoupon, setInvalidCoupon] = React.useState(false);
    const [couponAdded, setCouponAdded] = React.useState(false);

    let keyword;
    let category;

    useEffect(() => {
        getCart();
        getBooks();
        getInvoice();

    }, []);

    let showLoader = () => {
        getCart();
    };
    let refresh = () => {
        getCart();
        getInvoice();
    };

    let getBooks = () => {
        setLoader(true);
        axios.get('/book', {params: {q: keyword, category: category}}).then((response) => {
            setBooks(response.data.data);
            setLoader(false);

        }).catch((error) => {

        });
    };
    let getCart = () => {
        axios.get('/cart/get').then((response) => {
            setCart(response.data.data);
        }).catch((error) => {

        });
    };
    let getInvoice = () => {
        axios.get('/invoice').then((response) => {
            setInvoice(response.data.data);
        }).catch((error) => {

        });
    };
    let addCoupon = () => {
        setLoader(true);
        console.log(couponCode);
        axios.post('/invoice/coupon/add', {
            coupon: couponCode
        }).then((response) => {
            refresh();
            setLoader(false);
            showCoupon(false);
            setInvalidCoupon(false);
            setCouponAdded(true);

        }).catch((error) => {
            setInvalidCoupon(true);
        });
    };
    let removeCoupon = () => {
        setLoader(true);
        console.log(couponCode);
        axios.post('/invoice/coupon/remove').then((response) => {
            refresh();
            setLoader(false);
            setCouponAdded(false);

        }).catch((error) => {
            setInvalidCoupon(true);
        });
    };

    let search = (q) => {
        keyword = q.target.value;
        getBooks();
    };
    let setCategoryFilter = (c) => {
        category = c;
        getBooks();
    };

    let showInvoiceDialog = (status) => {
        showInvoice(status);
    };

    let showCouponDialog = (status) => {
        showCoupon(status);
    };
    const handleCouponChange = (e) => {
        setCoupon(e.target.value);
    };

    return (
        <div>
            {loader && <LinearProgress/>}
            <Navbar invoice={invoice} search={search} showInvoice={showInvoiceDialog}/>
            <br/>
            <BottomNavigation showLabels>
                <BottomNavigationAction label="Fiction" onClick={() => setCategoryFilter('fiction')}
                                        icon={<ImportContactsIcon/>}/>
                <BottomNavigationAction label="Children" onClick={() => setCategoryFilter('children')}
                                        icon={<LocalLibraryIcon/>}/>
            </BottomNavigation>
            <Books books={bookList} refresh={refresh} loader={setLoader}/>


            <Dialog open={invoiceStatus} aria-labelledby="form-dialog-title" maxWidth={'lg'}>
                <DialogTitle id="form-dialog-title">Invoice</DialogTitle>
                <DialogContent>
                    <Invoice invoice={invoice} refresh={refresh}/>
                </DialogContent>
                <DialogActions>
                    {invoice && !invoice.coupon && <Button color="primary" onClick={() => showCouponDialog(true)}>
                        Add Coupon
                    </Button>}
                    {invoice && invoice.coupon && <Button color="primary" onClick={removeCoupon}>
                        Remove Coupon
                    </Button>}
                    <Button color="primary" onClick={() => showInvoiceDialog(false)}>
                        Close
                    </Button>
                    <Button color="primary" onClick={() => showInvoiceDialog(false)}>
                        Print
                    </Button>
                </DialogActions>
            </Dialog>

            <Dialog open={couponStatus} aria-labelledby="form-dialog-title" maxWidth={'md'}>
                <DialogTitle id="form-dialog-title">Add Coupon</DialogTitle>
                <DialogContent>
                    <TextField
                        onChange={handleCouponChange}
                        autoFocus
                        margin="dense"
                        id="name"
                        label="Coupon"
                        type="text"
                        fullWidth
                    />
                </DialogContent>
                <DialogActions>
                    {invalidCoupon && <div>Invalid Coupon</div>}
                    <Button color="primary" onClick={() => showCouponDialog(false)}>
                        Close
                    </Button>
                    <Button color="primary" onClick={() => {
                        addCoupon();
                    }}>
                        Add
                    </Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}
