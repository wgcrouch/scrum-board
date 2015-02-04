from flask import render_template
from .blueprint import site_routes


@site_routes.route('/', methods=['GET'])
def index():
    return render_template('index.html')
