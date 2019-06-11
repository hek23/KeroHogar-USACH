from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/users/', methods=['POST'])
def createUser():
    userData = request.get_json()
    query = "INSERT INTO clients (rut, name, password, email, phone, wholesaler) VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',{}) "
    wholesaler = (userData['wholesaler'] == 1)
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], userData['pass'], userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    cursor.execute("SELECT id FROM clients where rut=\'{}\';".format(userData['rut']))
    id = cursor.fetchone()[0]
    cursor.close()
    return Response(json.dumps({"id":id}), mimetype= 'application/json',status=201)

@current_app.route('/v1/users/<UserID>', methods=['PUT'])
@requires_auth
def editUser():
    userData = request.get_json()
    query = "UPDATE clients SET rut=\'{}\', name = \'{}\', password=\'{}\', email=\'{}\', phone=\'{}\', wholesaler={}"
    wholesaler = (userData['wholesaler'] == 1)
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], userData['pass'], userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    return Response(mimetype='application/json', status =200)

@current_app.route('/v1/users/login', methods=['POST'])
def login():
    userData = request.get_json()
    query = "SELECT COUNT(*) FROM clients where name=\'{}\' AND password=\'{}\'"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['name'], userData['pass']))
    if(cursor.fetchone() is None):
        return Response (mimetype='application/json', status = 401)
    else:
        return Response(mimetype='application/json', status = 200)