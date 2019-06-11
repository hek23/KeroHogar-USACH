from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/clients/<ID>/orders', methods=['GET'])
@requires_auth
def ordersByClient (ID):
    query = "SELECT id, delivery_status, payment_status, amount, delivery_date FROM clients WHERE client_id={}"
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
    orderQuery = "INSERT INTO orders (address_id, delivery_status, payment_status, amount, delivery_date) VALUES ({},{},{},{},\'{}\')"
    orderTimeBlockQuery =  "INSERT INTO order_time_block (order_id, time_block_id) VALUES ({}, {})"
    orderProductQuery = "INSERT INTO order_product (order_id, product_id, product_format_id, quantity) VALUES ({},{},{},{})"
    getOrderID = "SELECT id FROM orders where (address_id={} AND delivery_status={} AND payment_status={} AND amount={} AND delivery_date=\'{}\')"
    cursor = mysqlConnector.get_db().cursor()
    #
    #first insert order query
    #Status are false by default
    cursor.execute(orderQuery.format(orderDetails['addressID'],0,0,amount,orderDetails['delivery_date']))
    cursor.execute(getOrderID.format(orderDetails['addressID'],0,0,amount,orderDetails['delivery_date']))
    mysqlConnector.get_db().commit()
    orderID = cursor.fetchall()[-1][0]
    #Then orderTimeBlock
    for time_block in orderDetails['time_block']:
        cursor.execute(orderTimeBlockQuery.format(orderID, time_block['id']))
    for product in orderDetails['products']:
        cursor.execute(orderProductQuery.format(orderID,product['id'],product['format'],product['quantity']))
    mysqlConnector.get_db().commit()
    return Response(status=201, response=json.dumps({"id":orderID}), mimetype="application/json")

@current_app.route('/v1/orders/<orderID>', methods=['POST'])
@requires_auth
def getOrderDetails(ID, orderID):
    orderQuery = "SELECT "
    pass

