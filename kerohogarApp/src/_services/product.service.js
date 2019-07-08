import axios from 'axios';

export const productService = {
    loadAllProducts,
    loadProduct,
    loadProductFormats,
    loadProductFormat
};

async function loadAllProducts() {
    try {
        const response = await axios.get('products');
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProduct(product_id) {
    try {
        const response = await axios.get('products/' + product_id);
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProductFormats(product_id) {
    try {
        const response = await axios.get('products/' + product_id + '/formats');
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}

async function loadProductFormat(product_id, format_id) {
    try {
        const response = await axios.get('products/' + product_id + '/formats/' + format_id);
        return response.data;
    }
    catch (error) {
        console.log(error);
    }
}