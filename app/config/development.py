"""Config for development environment"""

from .base import *

DEBUG = True

SQLALCHEMY_DATABASE_URI = 'mysql://root:@localhost/scrum'