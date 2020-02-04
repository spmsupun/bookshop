import React from 'react';
import {makeStyles} from '@material-ui/core/styles';
import Book from './Book';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
const axios = require('axios').default;

const useStyles = makeStyles({
    root: {
        maxWidth: 345,
    },
    media: {
        height: 140,
    },
});

export default function Books(props) {

    const [open, setOpen] = React.useState(false);
    const [selectedBook, setBook] = React.useState(false);
    const [quantity, setQuantity] = React.useState(false);

    const handleClickOpen = (book) => {
        setOpen(true);
        setBook(book);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const handleQuantity = (e) => {
        setQuantity(e.target.value);
    };

    let addToCart = () => {
        axios.post('/cart/add', {book_id: selectedBook.id, quantity: quantity}).then((response) => {
            setOpen(false);
            props.refresh()
        }).catch((error) => {

        });
    };

    return (

        <div className="book_list_area">
            <Grid container spacing={3}>
                {props.books.map((bookItem) => {
                    return (<Grid item xs={2}>
                        <Book book={bookItem} key={bookItem.id} openCartAddWindow={handleClickOpen} closeCartAddWindow={handleClose}/>
                    </Grid>);
                })}
            </Grid>


            <Dialog open={open} onClose={handleClose} aria-labelledby="form-dialog-title" maxWidth={'md'}>
                <DialogTitle id="form-dialog-title">Add To Cart</DialogTitle>
                <DialogContent>
                    <DialogContentText>
                        Please Enter the Quantity:
                    </DialogContentText>
                    <TextField
                        onChange={handleQuantity}
                        autoFocus
                        margin="dense"
                        id="name"
                        label="Quantity"
                        type="number"
                        fullWidth
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose} color="primary">
                        Cancel
                    </Button>
                    <Button onClick={addToCart} color="primary">
                        Add To Cart
                    </Button>
                </DialogActions>
            </Dialog>

        </div>

    );
}
