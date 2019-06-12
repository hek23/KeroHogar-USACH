from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/timeblocks/available/<date>', methods=['GET'])
@requires_auth
def getAvailableTimeBlocks(date):
    query = "SELECT otb.time_block_id, COUNT(*) FROM orders o INNER JOIN order_time_block otb on o.id=otb.order_id where o.delivery_date = \'{}\' AND o.delivery_status=1 GROUP BY o.delivery_date, otb.time_block_id ORDER BY o.delivery_date;"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(date))
    ocupacion = cursor.fetchall()
    cursor.execute("SELECT id, max_orders, start, end FROM time_blocks")
    capacidad = cursor.fetchall()
    bloques= []
    diaBase = []
    for hora in capacidad:
        diaBase.append({"id":hora[0], "start":str(hora[2]), "end":str(hora[3])})

    for bloque in capacidad:
        #Reset, dia terminado
        for ocupado in ocupacion:
            if(bloque[0] == ocupado[0]):
                if(bloque[1] < ocupado[1]):
                    diaBase.remove({"id":bloque[0], "start":str(bloque[2]), "end":str(bloque[3])})
    
    return Response(json.dumps(diaBase), mimetype = 'application/json')




