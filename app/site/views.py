from flask import render_template
from .blueprint import site_routes


@site_routes.route('/', defaults={'path': ''}, methods=['GET'])
@site_routes.route('/<path:path>', methods=['GET'])
def index(path):
    return render_template('index.html')
