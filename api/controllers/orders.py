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

#@current_app.route('/v1/clients/<ID>/orders', methods=['POST'])
#@requires_auth
#def createOrder(ID):
#    orderDetails = request.get_json()


#@current_app.route('/v1/clients/<ID>/orders/<orderID>', methods=['POST'])
#@requires_auth
#def getOrderDetails(ID, orderID):
