from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/clients/<ID>/orders', methods=['GET'])
@requires_auth
def ordersByClient (ID):
    query = "SELECT id, delivery_status, payment_status, amount, delivery_date FROM kerhogar.clients WHERE client_id={}"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(ID))
    result = cursor.fetchall()
    orders = []
    for order in result:
        orders.append({
            "id": order[0],
            "delivery_status": order[1],
            "payment_status": order[2],
            "amount": order[3],
            "delivery_date": order[4]
        })
    return Response(json.dumps(orders), status=200, mimetype='application/json')

#WIP
@current_app.route('/v1/clients/<ID>/orders', methods=['POST'])
@requires_auth
def createOrder(ID):
    orderDetails = request.get_json()
    orderQuery = "INSERT INTO kerhogar.orders (address_id, delivery_status, payment_status, amount, delivery_date) VALUES ({},{},{},{},\'{}\')"
    orderTimeBlockQuery =  "INSERT INTO kerhogar.order_time_block (order_id, time_block) VALUES ({}, {})"
    orderProductQuery = "INSERT INTO kerhogar.order_product (order_id, product_id, product_format_id, quantity) VALUES ({},{},{},{}}"
    getOrderID = "SELECT id FROM kerhogar.orders where address_id={} AND delivery_status={} payment_status={} AND amount={} AND delivery_date={})"
    

{
    addressID: 1,
    amount: 12391,
    delivery_date: 2018-12-28,
    time_block:[
    {
        "id": 3
    },
    {
        "id":2
    }],
    products:[
    {
        "id":1,
        "format":2,
        "quantity":32
    }]
}


#@current_app.route('/v1/clients/<ID>/orders/<orderID>', methods=['POST'])
#@requires_auth
#def getOrderDetails(ID, orderID):

