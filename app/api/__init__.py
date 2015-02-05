from flask.ext.restful import Api
from . import blueprint, resources

api_routes = blueprint.api_routes

api = Api(api_routes)

api.add_resource(resources.Board, '/board/<int:id>')
api.add_resource(resources.BoardStories, '/board/<int:board_id>/stories')
api.add_resource(resources.BoardColumns, '/board/<int:board_id>/columns')