from helpers import mysqlConnector
from flask import current_app, g, Response
import json

@current_app.route('/v1/products/<ProdID>/discounts', methods=['GET'])
def getAllProductDiscounts(ProdID):
    sqlQuery = "SELECT id, discount_per_liter, min_quantity, max_quantity FROM kerohogar.product_discounts where id={}"
    cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery)
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
