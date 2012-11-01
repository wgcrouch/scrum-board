/**
 * Story Status Collection
 */
itsallagile.Collection.StoryStatuses = Backbone.Collection.extend({
    model: itsallagile.Model.StoryStatus,
    url: '/api/storyStatuses'
});
