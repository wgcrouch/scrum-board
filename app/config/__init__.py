def load_config(env=None):
    """Load config based on an environment variable"""
    import os
    from importlib import import_module

    env = env or os.getenv('CONFIG_ENV')
    if env is None:
        env = 'development'

    pkg = 'app.config'

    try:
        return import_module('.' + env, pkg)
    except IOError:
        raise IOError('Config file for "{}" environment does not exist'.format(env))
