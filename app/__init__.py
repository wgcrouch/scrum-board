"""Contains the constructor for the app"""

from flask import Flask
from flask.ext.sqlalchemy import SQLAlchemy
from flask.ext.migrate import Migrate
from flask_debugtoolbar import DebugToolbarExtension
from flask_wtf.csrf import CsrfProtect
from flask_mail import Mail
from .config import load_config


db = SQLAlchemy()
csrf = CsrfProtect()

mail = Mail()


def create_app(config=None):
    """Application factory, allows the config to be injected"""
    app = Flask(__name__)

    if config is None:
        config = load_config()

    app.config.from_object(config)

    db.init_app(app)
    csrf.init_app(app)
    toolbar = DebugToolbarExtension(app)
    mail.init_app(app)

    # Load routes from blueprints
    from .site import site_routes
    from .api import api_routes

    app.register_blueprint(site_routes)
    app.register_blueprint(api_routes, url_prefix='/api')

    return app
