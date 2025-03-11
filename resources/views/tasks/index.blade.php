<script>
function getTasks() {
    $.ajax({
        url: 'http://localhost:8000/api/task',
        type: 'get',
        success: function(result) {
            var html = '';
            $.each(result, function(index, item) {
                var lineThrough = result[index].status == 1 ? 'class="done"' : '';
                html += '<tr>';
                html += '<td>' + (index + 1) + '</td>';
                html += '<td ' + lineThrough + '>' + result[index].task_description + '</td>';
                html += '<td ' + lineThrough + '>' + result[index].task_owner + '</td>';
                html += '<td ' + lineThrough + '>' + result[index].eta + '</td>';
                html += '<td>';
                html += '<button class="btn btn-info btn-sm" onclick="editTask(' + result[index].id + ')"><i class="bi bi-pen-fill"></i></button>';
                html += '<button class="btn btn-success btn-sm" onclick="markAsDone(' + result[index].id + ')"><i class="bi bi-check-circle"></i></button>';
                html += '<button class="btn btn-danger btn-sm" onclick="deleteTask(' + result[index].id + ')"><i class="bi bi-trash"></i></button>';
                html += '</td>';
                html += '</tr>';
            });
            $('#taskTable').html(html);
        },
        error: function(response) {
            console.log('error', response.responseText);
        }
    });
}

function addTask() {
    $('#createTaskModal').modal('show');
}

function createTask() {
    var task_description = $('#createTaskDescription').val();
    var task_owner = $('#createTaskOwner').val();
    var task_email = $('#createTaskEmail').val();
    var task_ETA = $('#createTaskETA').val();
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/api/task',
        data: {
            task_description: task_description,
            task_owner: task_owner,
            task_email: task_email,
            eta: task_ETA
        },
        success: function() {
            $('#createTaskModal').modal('hide');
            getTasks();
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
}

function updateTask() {
    var task_description = $('#editTaskDescription').val();
    var task_owner = $('#editTaskOwner').val();
    var task_email = $('#editTaskEmail').val();
    var task_ETA = $('#editTaskETA').val();
    var task_id = $('#editTaskId').val();
    $.ajax({
        type: 'put',
        url: 'http://localhost:8000/api/task/' + task_id,
        data: {
            task_description: task_description,
            task_owner: task_owner,
            task_email: task_email,
            eta: task_ETA
        },
        success: function() {
            $('#editTaskModal').modal('hide');
            getTasks();
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
}

function markAsDone(id) {
    $('#doneTaskId').val(id);
    $('#doneTaskModal').modal('show');
}

function updateMarkDone() {
    var task_id = $('#doneTaskId').val();
    $.ajax({
        type: 'put',
        url: 'http://localhost:8000/api/task/' + task_id,
        data: {
            status: 1
        },
        success: function() {
            $('#doneTaskModal').modal('hide');
            getTasks();
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
}

function deleteTask(id) {
    $('#deleteTaskId').val(id);
    $('#deleteTaskModal').modal('show');
}

function updateTaskDelete() {
    var task_id = $('#deleteTaskId').val();
    $.ajax({
        type: 'delete',
        url: 'http://localhost:8000/api/task/' + task_id,
        success: function() {
            $('#deleteTaskModal').modal('hide');
            getTasks();
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
}

function editTask(id) {
    $.ajax({
        type: 'get',
        url: 'http://localhost:8000/api/task/' + id,
        success: function(result) {
            $('#editTaskId').val(result.id);
            $('#editTaskDescription').val(result.task_description);
            $('#editTaskOwner').val(result.task_owner);
            $('#editTaskEmail').val(result.task_email);
            $('#editTaskETA').val(result.eta);
            $('#editTaskModal').modal('show');
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
}
</script>