from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json

@current_app.route('/v1/users/', methods=['POST'])
def createUser():
    userData = request.get_json()
    query = "INSERT INTO kerhogar.clients (rut, name, password, email, phone, wholesaler) VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',{}) "
    wholesaler = (userData['wholesaler'] == 1)
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], userData['pass'], userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    cursor.execute("SELECT id FROM kerhogar.clients where rut=\'{}\';".format(userData['rut']))
    id = cursor.fetchone()[0]
    cursor.close()
    return Response(json.dumps({"id":id}), mimetype= 'application/json',status=201)

@current_app.route('/v1/users/<UserID>', methods=['PUT'])
def editUser():
    userData = request.get_json()
    query = "UPDATE kerhogar.clients SET rut=\'{}\', name = \'{}\', password=\'{}\', email=\'{}\', phone=\'{}\', wholesaler={}"
    wholesaler = (userData['wholesaler'] == 1)
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], userData['pass'], userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    return Response(mimetype='application/json', status =200)