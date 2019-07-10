from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from flask_jwt_extended import jwt_required
from .users import user_required

@current_app.route('/v1/products/<Id>/formats',methods=['GET'])
@user_required
def getFormatsByProduct(Id):
	sqlQuery = "SELECT id, name, capacity, added_price, minimum_quantity FROM product_formats where product_id={};"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(Id))
	result = cursor.fetchall()
	cursor.close()
	if (result is None):
		return Response(json.dumps({}),mimetype='application/json')
	formats = []
	for row in result:
		format = {
			"id" : row[0],
			"name" : row[1],
			"capacity": row[2],
			"added_price" :row[3],
			"minimum_quantity" : row[4]
		}
		formats.append(format)
	return Response(json.dumps(formats), mimetype='application/json')

@current_app.route('/v1/products/<ProdId>/formats/<FormId>',methods=['GET'])
@user_required
def getFormatByProduct(ProdId,FormId):
	sqlQuery = "SELECT name, capacity, added_price, minimum_quantity FROM product_formats where product_id={} and id={};"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(ProdId,FormId))
	result = cursor.fetchone()
	cursor.close()
	if (result is None):
		return Response(json.dumps({}), mimetype='application/json')
	format = {"name":result[0], "capacity":result[1], "added_price":result[2], "minimum_quantity":result[3]}
	return Response(json.dumps(format), mimetype='application/json')