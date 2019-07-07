import axios from 'axios';
import { LocalStorage, format } from 'quasar';

export const productService = {
    loadAllProducts,
    loadProduct,
    loadProductFormats,
    loadProductFormat
};

async function loadAllProducts() {
    try {
        const response = await axios.get('http://165.22.120.0:5000/v1/products');
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProduct(product_id) {
    try {
        const response = await axios.get('http://165.22.120.0:5000/v1/products/' + product_id);
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProductFormats(product_id) {
    try {
        const response = await axios.get('http://165.22.120.0:5000/v1/products/' + product_id + '/formats');
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProductFormat(product_id, format_id) {
    try {
        const response = await axios.get('http://165.22.120.0:5000/v1/products/' + product_id + '/formats/' + format_id);
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}