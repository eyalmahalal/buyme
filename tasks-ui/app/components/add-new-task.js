import Component from '@ember/component';

export default Component.extend({
    router: Ember.inject.service(),
    actions: {
        saveTask(taskName) {
            $.ajax({
                dataType: 'json',
                method: 'POST',
                async: true,
                url: 'http://localhost:8000/tasks/',
                data: { task_name:taskName },
                success: function(response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('ERROR');
                }
            });
            this.get('router').transitionTo('tasks');
        }
    }
});
