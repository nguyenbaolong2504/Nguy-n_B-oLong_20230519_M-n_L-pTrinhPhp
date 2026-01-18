let editMode = false;
let editId = null;

/* LOAD DATA */
function loadData() {
    $.get('index.php?c=student&a=api&action=list', function(res){
        let html = '';

        if (!res.data || res.data.length === 0) {
            html = '<tr><td colspan="6">Chưa có dữ liệu</td></tr>';
        } else {
            $.each(res.data, function(i, s){
                html += `<tr>
                    <td>${i + 1}</td>
                    <td>${s.code}</td>
                    <td>${s.full_name}</td>
                    <td>${s.email}</td>
                    <td>${s.dob ?? ''}</td>
                    <td>
                        <button onclick="edit(${s.id})">Sửa</button>
                        <button onclick="del(${s.id})">Xóa</button>
                    </td>
                </tr>`;
            });
        }

        $('#studentTable').html(html);
    }, 'json');
}

/* CREATE / UPDATE */
$('#studentForm').submit(function(e){
    e.preventDefault();

    let action = editMode ? 'update' : 'create';
    let data = $(this).serialize() + '&action=' + action;

    if (editMode) {
        data += '&id=' + editId;
    }

    $.post('index.php?c=student&a=api', data, function(res){
        if (res.success) {
            alert(res.message);
            resetForm();
            loadData(); // ✅ cập nhật bảng
        } else {
            alert(JSON.stringify(res.errors || res.message));
        }
    }, 'json');
});

/* EDIT */
function edit(id){
    $.get('index.php?c=student&a=api&action=list', function(res){
        const s = res.data.find(x => x.id == id);
        if (!s) return;

        editMode = true;
        editId = id;

        $('[name=code]').val(s.code);
        $('[name=full_name]').val(s.full_name);
        $('[name=email]').val(s.email);
        $('[name=dob]').val(s.dob);

        $('#studentForm button').text('Cập nhật');
    }, 'json');
}

/* DELETE */
function del(id){
    if (confirm('Xóa sinh viên này?')) {
        $.post('index.php?c=student&a=api',
            { action: 'delete', id: id },
            function(res){
                if (res.success) {
                    loadData();
                } else {
                    alert(res.message);
                }
            },
            'json'
        );
    }
}

/* RESET */
function resetForm(){
    $('#studentForm')[0].reset();
    editMode = false;
    editId = null;
    $('#studentForm button').text('Thêm');
}

loadData();
