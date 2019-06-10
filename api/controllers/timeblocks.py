from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/timeblocks/available/<date>', methods=['GET'])
@requires_auth
def getAvailableTimeBlocks(date):
    query = "SELECT otb.time_block_id, COUNT(*) FROM kerhogar.orders o INNER JOIN kerhogar.order_time_block otb on o.id=otb.order_id where o.delivery_date = \'{}\' AND o.delivery_status=1 GROUP BY o.delivery_date, otb.time_block_id;"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(date))
    ocupacion = cursor.fetchall()
    cursor.execute("SELECT id, max_orders, start, end FROM time_blocks")
    capacidad = cursor.fetchall()
    bloques= []
    for bloque in capacidad:
        for ocupado in ocupacion:
            if(bloque[0] == ocupado[0]):
                if(bloque[1] >ocupado[1]):
                    bloques.append({
                        "id": bloque[0],
                        "block": bloque[2] + "-" + bloque[3]
                    })
    return Response(json.dumps(bloques), mimetype = 'application/json')

