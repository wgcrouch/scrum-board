from flask import abort
from flask.ext.restful import Resource, fields, marshal
from .. import models




ticket_fields = {
    'id': fields.Integer,
    'story_id': fields.Integer,
    'column_id': fields.Integer,
    'content': fields.String,
    'status': fields.String,
    'type': fields.String,
    'created': fields.DateTime(dt_format='iso8601'),
    'updated': fields.DateTime(dt_format='iso8601')
}

story_fields = {
    'id': fields.Integer,
    'board_id': fields.Integer,
    'title': fields.String,
    'content': fields.String,
    'status': fields.String,
    'order': fields.Integer,
    'created': fields.DateTime(dt_format='iso8601'),
    'updated': fields.DateTime(dt_format='iso8601')
}

column_fields = {
    'id': fields.Integer,
    'title': fields.String,
    'order': fields.Integer,
    'board_id': fields.Integer,
    'tickets': fields.Nested(ticket_fields)
}

board_fields = {
    'id': fields.Integer,
    'title': fields.String,
    'stories': fields.Nested(story_fields),
    'columns': fields.Nested(column_fields),
    'created': fields.DateTime(dt_format='iso8601'),
    'updated': fields.DateTime(dt_format='iso8601')
}


class Board(Resource):
    def get(self, id):
        board = models.Board.query.get_or_404(id)
        return marshal(board, board_fields, envelope='board')


class BoardList(Resource):
    def get(self):
        boards = models.Board.query.all()
        return marshal(boards, board_fields, envelope='boards')


class BoardStories(Resource):
    def get(self, board_id):
        board = models.Board.query.get_or_404(board_id)
        stories = board.stories
        return marshal(stories, story_fields)


class BoardColumns(Resource):
    def get(self, board_id):
        board = models.Board.query.get_or_404(board_id)
        columns = board.columns
        return marshal(columns, column_fields)
