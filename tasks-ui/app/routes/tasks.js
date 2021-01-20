import Route from '@ember/routing/route';
import RSVP from 'rsvp';

export default Route.extend({
    model() {
        var tasks = [];
        var doneTasks = 0;

        $.ajax({
            dataType: 'json',
            async: false,
            url: 'http://localhost:8000/tasks/',
            success: function(response) {
               response['data'].forEach(function(element){
                   tasks.push(element);
                   if (element.done) {
                       doneTasks++;
                   }
               });
            }
        });

        var total = tasks.length;
        var toFinish = total - doneTasks;

        return RSVP.hash({
            tasks: tasks,
            total: total,
            done: doneTasks,
            tofinish: toFinish
        });
    }
});
