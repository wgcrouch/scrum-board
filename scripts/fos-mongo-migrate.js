db.users.find().forEach(function(user) { 
    user.username = user.usernameCanonical = user.email.match(/^(.*)@/)[1];
    user.enabled = true;
    user.expired = false;
    user.locked = false;
    user.emailCanonical = user.email;
    user.roles = user.roles || {};
    db.users.save(user);
});

