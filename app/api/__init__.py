from flask.ext.restful import Api
from . import blueprint, resources

api_routes = blueprint.api_routes

api = Api(api_routes)

api.add_resource(resources.Board, '/boards/<int:id>')
api.add_resource(resources.BoardList, '/boards/')
api.add_resource(resources.BoardStories, '/boards/<int:board_id>/stories')
api.add_resource(resources.BoardColumns, '/boards/<int:board_id>/columns')