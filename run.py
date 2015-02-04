from flask.ext.script import Manager, commands, Shell
from flask.ext.migrate import Migrate, MigrateCommand
from app import create_app, db, models

app = create_app()

migrate = Migrate(app, db)
manager = Manager(app)
manager.add_command('db', MigrateCommand)
manager.add_command('routes', commands.ShowUrls())
manager.add_command('clean', commands.Clean())


def _make_context():
    return dict(app=app, db=db, models=models)

manager.add_command("shell", Shell(make_context=_make_context))

if __name__ == '__main__':
    manager.run()
