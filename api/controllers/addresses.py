from helpers import mysqlConnector
from flask import current_app, g, Response
import json

@current_app.route('/v1/users/<UserID>/addresses', methods=['GET'])
def getAllAdresses(UserID):
    sqlQuery = "SELECT a.id, t.name, a.address, a.alias FROM kerhogar.addresses a INNER JOIN kerhogar.towns t on t.id = a.town_id where a.client_id ={}"
    cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(UserID))
	result = cursor.fetchall()
	if(result is None):
		cursor.close()
		return Response(json.dumps({}), mimetype='application/json')
	addresses = []
    for addr in result:
        addresses.append({
            id: addr[0],
            town: addr[1],
            addr: addr[2],
            alias: addr[3]
        })
    cursor.close()
    return Response(json.dumps(addresses),  mimetype='application/json')

#@current_app.route('/v1/users/<UserID>/addresses', methods=['POST'])
#def createAddress(UserID):
