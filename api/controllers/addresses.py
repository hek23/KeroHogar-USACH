from helpers import mysqlConnector
from flask import current_app, g, Response,request
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

@current_app.route('/v1/users/<UserID>/addresses', methods=['POST'])
def createAddress(UserID):
    addrInfo = request.get_json()
    insertQuery = "INSERT INTO kerhogar.addresses (town_id,address, alias,client_id) VALUES ({}, \'{}\', \'{}\', {})"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(insertQuery.format(addrInfo['townID'], addrInfo['addr'],addrInfo ['alias'], UserID))
    mysqlConnector.get_db().commit()
    cursor.close()
    return Response(status=201)

@current_app.route('/v1/users/<UserID>/addresses/<AddrID>', methods=['PUT'])
def editAddress(UserID, AddrID):
    addrInfo = request.get_json()
    query = "UPDATE kerhogar.addresses SET town_id={}, address=\'{}\',alias=\'{}\' where client_id={} AND id={};"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(addrInfo['townID'], addrInfo['addr'], addrInfo['alias'], UserID, AddrID))
    mysqlConnector.get_db().commit()
    cursor.close()
    return Response(status=200)

@current_app.route('/v1/users/<UserID>/addresses/<AddrID>', methods=['DELETE'])
def deleteAddress(UserID,AddrID):
    query = "DELETE FROM kerhogar.addresses where id={} and client_id={}"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(AddrID,UserID))
    mysqlConnector.get_db().commit()
    cursor.close()
    return Response(status=200)

