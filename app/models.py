from app import db


class TimeStamped(object):
    created = db.Column(db.DateTime, default=db.func.now())
    updated = db.Column(db.DateTime, default=db.func.now(),
                        onupdate=db.func.now())


class Board(db.Model, TimeStamped):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255), nullable=False)


class BoardColumn(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255), nullable=False)
    board_id = db.Column(db.Integer, db.ForeignKey('board.id'))
    order = db.Column(db.Integer)
    category = db.relationship('Board', backref=db.backref('columns'))


class Story(db.Model, TimeStamped):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    content = db.Column(db.Text)
    order = db.Column(db.Integer)
    status = db.Column(db.String(30))
    board_id = db.Column(db.Integer, db.ForeignKey('board.id'))
    board = db.relationship('Board', backref=db.backref('stories'))


class Ticket(db.Model, TimeStamped):
    id = db.Column(db.Integer, primary_key=True)
    type = db.Column(db.String(30))
    status = db.Column(db.String(30))
    content = db.Column(db.Text)
    story_id = db.Column(db.Integer, db.ForeignKey('story.id'))
    story = db.relationship('Story', backref=db.backref('tickets'))
    board_column_id = db.Column(db.Integer, db.ForeignKey('board_column.id'))
    board_column = db.relationship('BoardColumn',
                                   backref=db.backref('tickets'))
