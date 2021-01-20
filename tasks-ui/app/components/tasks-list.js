import $ from 'jquery';
import Component from '@ember/component';

export default Component.extend({
    router: Ember.inject.service(),
    actions: {
        handleCheckboxChange(status) {
            $.ajax({
                dataType: 'json',
                method: 'PUT',
                async: true,
                url: 'http://localhost:8000/tasks/'+status.name+"?done="+status.checked,
                data: { done:status.checked },
                success: function(response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('ERROR PUT');
                }
            });
            this.get('router').transitionTo('tasks');
        },

        addTask() {
            console.log('add');
        },

        submitConfirm(taskId, confirmType) {
            switch (confirmType) {
                case 'delete':
                    this.send('sendDelete',taskId);
                    break;
                default:
                    break;
            }
            this.set('confirmShown', false);
        },

        cancelConfirm() {
            this.set('confirmShown', false);
        },

        deleteTask(taskId) {
            var confirmShown = this.get('confirmShown');
            if (confirmShown != true) {
                this.set('taskId', taskId);
                this.set('confirmType', "delete");
                this.set('confirmShown', true);
            }
        },

        sendDelete(taskId) {
            $.ajax({
                dataType: 'json',
                method: 'DELETE',
                crossDomain: true,
                async: true,
                url: 'http://localhost:8000/tasks/'+taskId,
                success: function(response) {
                    if (response.success || response.success == 1) {
                        alert('Successfully delete this task');
                    }
                    else {
                        alert('Error in deleteing this task');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('ERROR DELETE');
                }
            });
            this.get('router').transitionTo('tasks');
        }
    }
});
