from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
import bcrypt
from flask_jwt_extended import jwt_required, create_access_token, create_refresh_token, verify_jwt_in_request, get_jwt_identity,jwt_refresh_token_required
import pymysql
from functools import wraps

def user_required(fn):
    @wraps(fn)
    def wrapper(*args, **kwargs):
        verify_jwt_in_request()
        identity = get_jwt_identity()
        splited = identity.split("::")
        cursor = mysqlConnector.get_db().cursor()
        cursor.execute("SELECT password FROM clients WHERE rut=\'{}\'".format(splited[0]))
        pwd = cursor.fetchone()
        cursor.close()
        if (pwd is None):
            return Response(mimetype='application/json', status = 400, response=json.dumps({"msg":"No user/pass found"}))
        elif (pwd[0] != splited[1]):
            return Response(mimetype='application/json', status = 400, response=json.dumps({"msg":"pass missed"}))
        else:    
            return fn(*args, **kwargs)
    return wrapper

@current_app.route('/v1/users', methods=['GET'])
@user_required
def getUserInfo():
    query = "SELECT name, email, phone FROM clients where rut = \'{}\'"
    rut = get_jwt_identity().split("::")[0]
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(rut))
    results = cursor.fetchone()
    cursor.close()
    return Response(json.dumps({"rut":rut, "name":results[0], "email":results[1] , "phone":results[2]}), mimetype='application/json')
@current_app.route('/v1/users', methods=['POST'])
def createUser():
    userData = request.get_json()
    query = "INSERT INTO clients (rut, name, password, email, phone, wholesaler) VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',{}) "
    wholesaler = (userData['wholesaler'] == 1) 
    cursor = mysqlConnector.get_db().cursor()
    try:
        cursor.execute(query.format(userData['rut'], userData['name'], bcrypt.hashpw(userData['pass'].encode('utf-8'), bcrypt.gensalt(12)).decode('utf-8'), userData['email'], userData['phone'], wholesaler))
        mysqlConnector.get_db().commit()
        cursor.execute("SELECT id FROM clients where rut=\'{}\';".format(userData['rut']))
        id = cursor.fetchone()[0]
        cursor.close()
        return Response(json.dumps({"id":id}), mimetype= 'application/json',status=201)
    except pymysql.err.IntegrityError:
        cursor.close()
        return Response(json.dumps({"error": "Rut ya existente"}), mimetype='application/json', status=400)

@current_app.route('/v1/users/', methods=['PUT'])
@user_required
def editUser():
    newUserData = request.get_json()
    query = "UPDATE clients SET"
    params = []
    if 'name' in newUserData:
        query = query + " name=\{}\'"
        params.append(newUserData['name'])
    if 'password' in newUserData:
        if len(params)>0:
            query=query+","
        query= query + " password=\'{}\'"
        params.append(bcrypt.hashpw(userData['pass'].encode('utf-8'), bcrypt.gensalt(12)).decode('utf-8'))
    if 'email' in newUserData:
        if len(params)>0:
            query=query+","
        query= query + " email=\'{}\'"
        params.append(newUserData['email'])
    if 'phone' in newUserData:
        if len(params)>0:
            query=query+","
        query= query + " phone=\'{}\'"
        params.append(newUserData['phone'])
    if 'wholesaler' in newUserData:
        if len(params)>0:
            query=query+","
        query= query + " wholesaler=\'{}\'"
        params.append((userData['wholesaler'] == 1))
    query = query + " WHERE rut='\{}\'"
    params.append(get_jwt_identity().split("::")[0])
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(*params))
    cursor.close()
    mysqlConnector.get_db().commit()
    return Response(mimetype='application/json', status =200)

@current_app.route('/v1/users/login', methods=['POST'])
def login():
    userData = request.get_json()
    if not userData['name']:
        return Response(mimetype='application/json', status = 400, response=json.dumps({"msg": "Username missing"}))
    if not userData['pass']:
        return Response(mimetype='application/json', status = 400, response=json.dumps({"msg": "Password missing"}))
    query = "SELECT password, id FROM clients where rut=\'{}\'"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['name']))
    pwd = cursor.fetchone()
    cursor.close()
    if pwd is None:
        return Response(status = 400)
    if not(bcrypt.checkpw(userData['pass'].encode('utf-8'), pwd[0].encode('utf-8'))):
        return Response (mimetype='application/json', status = 401)
    else:
        return Response(mimetype='application/json', status = 200, response=json.dumps({"id":pwd[1] ,"token": create_access_token(identity=(userData['name'] +"::" +pwd[0])), "refresh": create_refresh_token(identity=userData['name'] +"::" +pwd[0])}))

@current_app.route('/v1/users/refresh', methods=['POST'])
@jwt_refresh_token_required
def refresh():
    userData = get_jwt_identity().split("::")
    query = "SELECT password FROM clients where rut=\'{}\'"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData[0]))
    pwd = cursor.fetchone()
    cursor.close()
    if pwd is None:
        return Response(status = 400, mimetype='application/json', response=json.dumps({"msg":"User doesn't exist"}))
    if not(userData[1].encode('utf-8') == pwd[0].encode('utf-8')):
        return Response (mimetype='application/json', status = 401, response=json.dumps({"msg":"Invalid Password"}))
    else:
        return Response(mimetype='application/json', status = 200, response=json.dumps({"token": create_access_token(identity=(userData[0] +"::" +pwd[0]))}))