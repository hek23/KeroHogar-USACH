from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/products/<ProdID>/discounts', methods=['GET'])
@requires_auth
def getAllProductDiscounts(ProdID):
	sqlQuery = "SELECT id, discount_per_liter, min_quantity, max_quantity FROM product_discounts where id={}"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(ProdID))
	result = cursor.fetchall()
	if(result is None):
		cursor.close()
		return Response(json.dumps({}), mimetype='application/json')
	discounts = []
	for discount in result:
		discounts.append({
						"id": discount[0],
						"discount_per_liter": discount[1],
						"min_qty": discount[2],
						"max_qty": discount[3]
		})
	cursor.close()
	return Response(json.dumps(discounts),  mimetype='application/json')


@current_app.route('/v1/products/discounts', methods=['GET'])
@requires_auth
def getAllDiscounts():
	sqlQuery = "SELECT id, discount_per_liter, min_quantity, max_quantity. product_id FROM product_discounts "
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(ProdID))
	result = cursor.fetchall()
	if(result is None):
		cursor.close()
		return Response(json.dumps({}), mimetype='application/json')
	discounts = []
	for discount in result:
		discounts.append({
						"id": discount[0],
						"discount_per_liter": discount[1],
						"min_qty": discount[2],
						"max_qty": discount[3],
						"product_id": discount[4]
		})
	cursor.close()
	return Response(json.dumps(discounts),  mimetype='application/json')


