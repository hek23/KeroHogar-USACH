from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
from flask_jwt_extended import jwt_required, get_jwt_identity
from .users import user_required
import math

@current_app.route('/v1/clients/<ID>/orders', methods=['GET'])
@user_required
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
@user_required
def createOrder(ID):
    orderDetails = request.get_json()
    orderQuery = "INSERT INTO orders (address_id, delivery_status, payment_status, amount, delivery_date) VALUES ({},{},{},{},\'{}\')"
    orderTimeBlockQuery =  "INSERT INTO order_time_block (order_id, time_block_id) VALUES ({}, {})"
    orderProductQuery = "INSERT INTO order_product (order_id, product_id, product_format_id, quantity) VALUES ({},{},{},{})"
    getOrderID = "SELECT id FROM orders where (address_id={} AND delivery_status={} AND payment_status={} AND amount={} AND delivery_date=\'{}\')"
    
    cursor = mysqlConnector.get_db().cursor()
    amount = 0

    #Verify identity with JWT and address
    identity = get_jwt_identity()
    splited = identity.split("::")
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute("SELECT id FROM clients where rut=\'{}\'".format(splited[0]))
    vari= cursor.fetchone()
    print(int(vari[0]) == int(ID))
    #Verify if id from DB is same as id in URL
    if(int(vari[0]) != int(ID)):
        #Bad Request
        return Response(status=400, response=json.dumps({"msg": "Token doesn't belongs to UserID"}), mimetype="application/json")
    #Verify if address belongs to user
    cursor.execute("SELECT count(*) FROM addresses where id={} and client_id={}".format(orderDetails['addressID'],ID))
    if not(cursor.fetchone()[0]):
        #Bad Request (address doesn't valid)
        return Response(status=400, response=json.dumps({"msg": "Address doesn't belong to user"}), mimetype="application/json")
    cursor.execute("SELECT wholesaler FROM clients where id={}".format(ID))
    isWholesaler = cursor.fetchone()[0]
    if (isWholesaler):
        priceQuery = "SELECT wholesaler_price FROM products where id={}"
    else:
        priceQuery = "SELECT price FROM products where id={}"
    for product in orderDetails['products']:
        
        #Normal price
        cursor.execute(priceQuery.format(product['id']))
        amount = int(cursor.fetchone()[0]) * int(product['quantity']) + amount
        #Apply Discounts
        #cursor.execute("SELECT discount_per_liter FROM product_discounts WHERE (min_quantity>{0} OR min_quantity={0}) AND (max_quantity<{0} OR min_quantity={0})".format(formatID))
        try:
            if not isWholesaler:
                cursor.execute("SELECT discount_per_liter FROM product_discounts WHERE min_quantity <= {} ORDER BY min_quantity DESC".format(product['quantity']))
                amount = cursor.fetchone()[0]*-1 * product['quantity'] + amount
        except IndexError:
            pass

        try:
            #Add format price
            cursor.execute("SELECT added_price, capacity FROM product_formats where id={} and capacity>0".format(product['format']))
            formatInfo = cursor.fetchone()
            #Apply format
            amount=amount+(math.ceil(orderDetails['quantity']/formatInfo[1])) *formatInfo[0]
        except KeyError:
            pass
    #first insert order query
    #Status are false by default
    cursor.execute(orderQuery.format(orderDetails['addressID'],1,1,amount,orderDetails['delivery_date']))
    cursor.execute(getOrderID.format(orderDetails['addressID'],1,1,amount,orderDetails['delivery_date']))
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
@user_required
def getOrderDetails(ID, orderID):
    orderQuery = "SELECT "
    pass

