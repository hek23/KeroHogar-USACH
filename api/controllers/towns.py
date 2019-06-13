from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from flask_jwt_extended import jwt_required
from .users import user_required

@current_app.route('/v1/towns', methods=['GET'])
def getTowns():
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute("SELECT id, name FROM towns;")
    result = cursor.fetchall()
    towns = []
    for town in result:
        towns.append({
            "id": town[0],
            "name": town[1]
        })
    cursor.close()
    return Response(json.dumps(towns), mimetype='application/json')
    