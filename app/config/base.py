""" Base config file, all others inherit from this
"""
import os

DEBUG = False

SQLALCHEMY_DATABASE_URI = 'sqlite:///app.db'
SECRET_KEY = 'sdf23f23ffsdFDFDF23525FSDFSDF4235hgfdgdfg'
BASE_DIR = os.path.abspath(os.path.dirname(os.path.dirname(__file__)))
CSRF_ENABLED = True

DEBUG_TB_INTERCEPT_REDIRECTS = False

SECURITY_CONFIRMABLE = False
SECURITY_TRACKABLE = True
