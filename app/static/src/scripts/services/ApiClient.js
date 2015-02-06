'use strict';
/**
 * Api client build on top of superagent
 *
 * Provides the basic http methods, sets up superagent to return promises and
 * send the csrf header
 */

var superagent = require('superagent'),
    Bluebird = require("bluebird"),
    Request = require("superagent").Request;

/**
 * Custom Errors to return when rejecting the promise
 * Services should create their own errors or error predicates
 */

function RequestError(response) {
    this.response =  response;
    this.message = response.error.message;
    this.name = "RequestError";
}
RequestError.prototype = Object.create(Error.prototype);
RequestError.prototype.constructor = RequestError;

function ServerError(response) {
    this.response =  response;
    this.message = response.error.message;
    this.name = "ServerError";
    Error.captureStackTrace(this, ServerError);
}
ServerError.prototype = Object.create(Error.prototype);
ServerError.prototype.constructor = ServerError;

function UnauthorisedError(response) {
    this.response =  response;
    this.message = response.error.message;
    this.name = "UnauthorisedError";
}
UnauthorisedError.prototype = Object.create(Error.prototype);
UnauthorisedError.prototype.constructor = UnauthorisedError;

/**
 * Add promises support to superagent
 * @returns {Bluebird}
 */
Request.prototype.promise = function() {
    var self = this;
    return new Bluebird(function(resolve, reject){
        Request.prototype.end.call(self, function(error, res) {
            if (error) {
                reject(error);
            }
            if (!res.ok) {
                var rejectError = null;
                switch (res.status) {
                    case 500:
                        rejectError = new ServerError(res);
                        break;
                    case 401:
                        rejectError = new UnauthorisedError(res);
                        break;
                    default:
                        rejectError = new RequestError(res);
                        break;
                }

                reject(rejectError);
            } else {
                resolve(res);
            }
        });
    });
};

var token = null;

/**
 * Plugin to add the csrf token to requests
 */
var csrf = function(request) {
    request.set('X-CSRF-Token', token);
    return request;
};

var defaults = function(request) {
    request.set('Accept', 'application/json');
    return request;
};

var ApiClient = {
    ServerError: ServerError,
    RequestError: RequestError,
    UnauthorisedError: UnauthorisedError,

    post: function(url, data, form) {
        var post =  superagent.post(url)
            .use(csrf)
            .use(defaults)
            .send(data);

        if (form) {
            post = post.type('form');
        }

        return post.promise();
    },

    put: function(url, data) {
        return superagent.put(url)
            .use(csrf)
            .use(defaults)
            .send(data)
            .promise();
    },

    get: function(url, data) {
        return superagent.get(url)
            .use(defaults)
            .query(data)
            .promise();
    },

    delete: function(url) {
        return superagent.del(url)
            .use(csrf)
            .use(defaults)
            .promise();
    },

    postFile: function(url, name, file) {
        return superagent.post(url)
            .use(csrf)
            .use(defaults)
            .attach(name, file, file.name)
            .send()
            .promise();
    },

    setToken: function(newToken) {
        token = newToken;
    },

    getToken: function() {
        return token;
    }
};


module.exports = ApiClient;
